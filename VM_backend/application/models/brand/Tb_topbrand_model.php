<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_topbrand_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('brand/brand/'); // 上傳路徑
    }

    /******************** brand Model ********************/
    public function get_topbrand_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_topbrand_join($langId);
        
        $query = $this->db->get('tb_brand_top as brand_top');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function update_topbrand($post)
    {
        $this->db->update_batch('tb_brand_top', $post,'Id');
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
    private function set_topbrand_join($langId)
    {
        $this->db->select('brand_top.*,brand.*');
        $this->db->join('tb_brand as brand','brand.brandId = brand_top.brandId','inner');
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
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'brandId', 'cId' /* brand Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}