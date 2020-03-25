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
    public function get_inspiration_related_product_select($filter)
    {
        $this->set_filter($filter);
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
        $this->db->select('product.productImg,product.price,product.productId,inspiration.inspirationImg');
        if($langId):
            $this->db->select('product_lang.name,product_lang.introduction,product_lang.description,product_lang.detail,inspiration_lang.title,inspiration_lang.content');
            $this->db->join('tb_product as product','product.productId = ');
        endif;
    }
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
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