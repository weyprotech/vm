<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_brand_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('brand/brand/'); // 上傳路徑
    }

    /******************** brand Model ********************/
    public function get_brand_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_brand_join($langId);
        $query = $this->db->where('brand.is_enable', 1)->get('tb_brand as brand');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_brand($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_brand_join($langId);
        return $this->db->where('brand.is_enable', 1)->count_all_results('tb_brand as brand');
    }

    public function get_brand_by_id($brandId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_brand_join($langId);
        $this->set_filter(array(array('field' => 'brand.is_enable', 'value' => $boolean['enable']), array('field' => 'brand.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('brand.brandId', $brandId)->get('tb_brand as brand');

        if ($query->num_rows() > 0):
            $brand = $query->row();
            if (!$langId):
                $brand->langList = $this->get_brand_lang_select(array(array('field' => 'brandId', 'value' => $brand->brandId)));
            endif;

            return $brand;
        endif;

        return false;
    }

    public function insert_brand($post)
    {
        $post['order'] = $this->count_brand() + 1;
        $post['create_at'] =  date("Y-m-d H:i:s");
        $post['is_enable'] = 1;
        $post['is_visible'] = 1;
        $insert = $this->check_db_data($post);
        if (isset($_FILES['brandiconImg']) && !$_FILES['brandiconImg']['error']):
            $insert['brandiconImg'] = $this->uploadFile('brandicon', $post['brandId'] . '/', 100);
        endif;
        if (isset($_FILES['brandImg']) && !$_FILES['brandImg']['error']):
            $insert['brandImg'] = $this->uploadFile('brand',  $post['brandId'] . '/', 600);
        endif;
        if (isset($_FILES['brandindexImg']) && !$_FILES['brandindexImg']['error']):
            $insert['brandindexImg'] = $this->uploadFile('brandindex',  $post['brandId'] . '/', 360);
        endif;

        if (isset($_FILES['brandstory2_1Img']) && !$_FILES['brandstory2_1Img']['error']):
            $insert['brandstory2_1Img'] = $this->uploadFile('brandstory2_1', $post['brandId'] . '/', 940);
        endif;
        if (isset($_FILES['brandstory2_2Img']) && !$_FILES['brandstory2_2Img']['error']):
            $insert['brandstory2_2Img'] = $this->uploadFile('brandstory2_2',  $post['brandId'] . '/', 941);
        endif;
        if (isset($_FILES['brandstory2_3Img']) && !$_FILES['brandstory2_3Img']['error']):
            $insert['brandstory2_3Img'] = $this->uploadFile('brandstory2_3',  $post['brandId'] . '/', 940);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_brand_lang($post['brandId'], $post['langList']);
        endif;

        $this->insert('tb_brand', $insert);
        return $this->db->insert_id();
    }

    public function update_brand($brand, $post)
    {
        $update = $this->check_db_data($post);
        if (isset($_FILES['brandiconImg']) && !$_FILES['brandiconImg']['error']):
            $update['brandiconImg'] = $this->uploadFile('brandicon', $brand->brandId . '/', 100);
        endif;
        if (isset($_FILES['brandImg']) && !$_FILES['brandImg']['error']):
            $update['brandImg'] = $this->uploadFile('brand', $brand->brandId . '/', 600);
        endif;
        if (isset($_FILES['brandindexImg']) && !$_FILES['brandindexImg']['error']):
            $update['brandindexImg'] = $this->uploadFile('brandindex', $brand->brandId . '/', 360);
        endif;       
        
        if (isset($_FILES['brandstory2_1Img']) && !$_FILES['brandstory2_1Img']['error']):
            $update['brandstory2_1Img'] = $this->uploadFile('brandstory2_1', $brand->brandId . '/', 940);
        endif;
        if (isset($_FILES['brandstory2_2Img']) && !$_FILES['brandstory2_2Img']['error']):
            $update['brandstory2_2Img'] = $this->uploadFile('brandstory2_2',  $brand->brandId . '/', 941);
        endif;
        if (isset($_FILES['brandstory2_3Img']) && !$_FILES['brandstory2_3Img']['error']):
            $update['brandstory2_3Img'] = $this->uploadFile('brandstory2_3',  $brand->brandId . '/', 940);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_brand_lang($brand->brandId, $post['langList']);
        endif;

        $this->update('tb_brand', $update, array('brandId' => $brand->brandId));
        return true;
    }

    public function delete_brand($brand)
    {
        $this->delete('tb_brand', $this->check_db_data(array('is_enable' => 0)), array('brandId' => $brand->brandId));
        return $this->reorder_brand();
    }

    /*************** 重新排序 ***************/
    private function reorder_brand()
    {
        $result = $this->get_brand_select(false, array(array('field' => 'brand.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('brandId' => $row->brandId, 'order' => $i + 1));
            endforeach;
            return $this->db->update_batch('tb_brand', $order, 'brandId');
        endif;

        return true;
    }

    /*************** brand Lang Model ***************/
    private function get_brand_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_brand_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_brand_lang($brandId, $update)
    {
        $this->db->where('brandId', $brandId)->update_batch('tb_brand_lang', $update, 'langId');
      
        $langList = $this->get_brand_lang_select(array(array('field' => 'brandId', 'value' => $brandId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_brand_lang', $insert);
        endif;

        return true;
    }
    /*************** End brand Lang Model ***************/
    /******************** End brand Model ********************/

    /******************** Private Function ********************/
    private function set_brand_join($langId)
    {
        $this->db->select('brand.*');
        if ($langId):
            $this->db->select('lang.name');
            $this->db->join('tb_brand_lang as lang', 'lang.brandId = brand.brandId AND lang.langId = ' . $langId);
        endif;
        return true;
    }

    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    case 'detail':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;
                    case 'brand_story_content':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'designerId', 'cId' /* brand Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}