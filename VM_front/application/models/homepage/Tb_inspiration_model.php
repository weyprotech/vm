<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_inspiration_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('inspiration/'); // 上傳路徑
    }

    /******************** inspiration Model ********************/
    public function get_inspiration_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_inspiration_join($langId);
        $query = $this->db->where('inspiration.is_enable', 1)->get('tb_inspiration as inspiration');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_inspiration($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_inspiration_join($langId);
        return $this->db->where('inspiration.is_enable', 1)->count_all_results('tb_inspiration as inspiration');
    }

    public function get_inspiration_by_id($inspirationId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_inspiration_join($langId);
        $this->set_filter(array(array('field' => 'inspiration.is_enable', 'value' => $boolean['enable']), array('field' => 'inspiration.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('inspiration.inspirationId', $inspirationId)->get('tb_inspiration as inspiration');

        if ($query->num_rows() > 0):
            $inspiration = $query->row();
            if (!$langId):
                $inspiration->langList = $this->get_inspiration_lang_select(array(array('field' => 'iId', 'value' => $inspiration->inspirationId)));
            endif;

            return $inspiration;
        endif;

        return false;
    }

    public function insert_inspiration($post)
    {
        $post['order'] = $this->count_inspiration() + 1;
        $post['create_at'] =  date("Y-m-d H:i:s");
        $post['is_enable'] = 1;
        $post['is_visible'] = 1;
        $insert = $this->check_db_data($post);
        if (isset($_FILES['inspirationImg']) && !$_FILES['inspirationImg']['error']):
            $insert['inspirationImg'] = $this->uploadFile('inspiration',  $post['inspirationId'] . '/', 240);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_inspiration_lang($post['inspirationId'], $post['langList']);
        endif;

        if(isset($post['related'])):
            $this->update_inspiration_related_product($post['inspirationId'], $post['related']);
        endif;

        $this->insert('tb_inspiration', $insert);
        return $this->db->insert_id();
    }

    public function update_inspiration($inspiration, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($_FILES['inspirationImg']) && !$_FILES['inspirationImg']['error']):
            $insert['inspirationImg'] = $this->uploadFile('inspiration',  $inspiration->inspirationId . '/', 240);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_inspiration_lang($inspiration->inspirationId, $post['langList']);
        endif;

        if(isset($post['related'])):
            $this->update_inspiration_related_product($inspiration->inspirationId, $post['related']);
        endif;

        $this->update('tb_inspiration', $update, array('inspirationId' => $inspiration->inspirationId));
        return true;
    }

    public function delete_inspiration($inspiration)
    {
        $this->delete('tb_inspiration', $this->check_db_data(array('is_enable' => 0)), array('inspirationId' => $inspiration->inspirationId));
        return $this->reorder_inspiration();
    }

    /*************** 重新排序 ***************/
    private function reorder_inspiration()
    {
        $result = $this->get_inspiration_select(false, array(array('field' => 'inspiration.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('inspirationId' => $row->inspirationId, 'order' => $i + 1));
            endforeach;
            return $this->db->update_batch('tb_inspiration', $order, 'inspirationId');
        endif;

        return true;
    }

    /*************** inspiration Lang Model ***************/
    private function get_inspiration_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_inspiration_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_inspiration_lang($inspirationId, $update)
    {
        $this->db->where('iId', $inspirationId)->update_batch('tb_inspiration_lang', $update, 'langId');
      
        $langList = $this->get_inspiration_lang_select(array(array('field' => 'iId', 'value' => $inspirationId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_inspiration_lang', $insert);
        endif;

        return true;
    }
    /*************** End inspiration Lang Model ***************/
    /*************** start inspiration related product Model ********/
    public function get_inspiration_related_product_select($filter = false,$order = false,$limit = false,$langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_inspiration_related_product_join($langId);
        $array = array();
        $query = $this->db->where('product.is_enable', 1)->get('tb_inspiration_related_product as relate_product');     
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $array[$lrow->Id] = $lrow;
            endforeach;
        endif;
        return $array;
    }

    private function update_inspiration_related_product($inspirationId,$update)
    {
        $this->db->where('iId',$inspirationId)->update_batch('tb_inspiration_related_product',$update,'Id');
        $productList = $this->get_inspiration_related_product_select(array(array('field' => 'iId','value' => $inspirationId)));

        $insert = array_diff_key($update,$productList);
        if(!empty($insert)):
            foreach($insert as $key => $value){
                unset($value['Id']);
            }
            return $this->db->insert_batch('tb_inspiration_related_product',$insert);
        endif;

        $delete = array_diff_key($productList,$update);
        if(!empty($delete)):
            foreach($delete as $key => $value):
                return $this->db->delete('tb_inspiration_related_product',array('id' => $value->Id));
            endforeach;
        endif;
        return true;
    }


    /*************** End inspiration related product Model ***************/

    /******************** End inspiration Model ********************/

    /******************** Private Function ********************/
    private function set_inspiration_join($langId)
    {
        $this->db->select('inspiration.*');
        if ($langId):
            $this->db->select('lang.title,lang.Content');
            $this->db->join('tb_inspiration_lang as lang', 'lang.iId = inspiration.inspirationId AND lang.langId = ' . $langId);
        endif;
        return true;
    }

    private function set_inspiration_related_product_join($langId)
    {
        $this->db->select('relate_product.Id,product.productImg,product.price,product.productId,inspiration.inspirationImg,inspiration.inspirationId, product.is_enable');
        $this->db->join('tb_product as product','product.productId = relate_product.pId','left');
        $this->db->join('tb_inspiration as inspiration','inspiration.inspirationId = relate_product.iId','left');
        $this->db->join('tb_product_category as minor', 'minor.categoryId = product.cId AND minor.is_enable', 'left');
        $this->db->join('tb_product_category as main', 'main.categoryId = minor.prevId AND main.is_enable', 'left');
        $this->db->join('tb_product_category as base','base.categoryId = main.prevId AND base.is_enable','left');
        if($langId):
            $this->db->select('product_lang.name,product_lang.introduction,product_lang.description,product_lang.detail,inspiration_lang.title,inspiration_lang.content,main_lang.name as mainName, minor_lang.name as minorName,base_lang.name as baseName');
            $this->db->join('tb_product_lang as product_lang','product_lang.pId = product.productId AND product_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_inspiration_lang as inspiration_lang','inspiration_lang.iId = inspiration.inspirationId and inspiration_lang.langId = '.$langId, 'left');
            $this->db->join('tb_product_category_lang as main_lang', 'main_lang.cId = minor.prevId AND main_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as minor_lang', 'minor_lang.cId = product.cId AND minor_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as base_lang','base_lang.cId = base.categoryId AND base_lang.langId = '.$langId,'left');
        endif;
    }
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('langList', 'uuid','related'))):
                switch ($field):
                    case 'content':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'designerId', 'cId' /* inspiration Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}