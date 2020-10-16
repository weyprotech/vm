<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_wish_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('designer/wish/'); // 上傳路徑
    }

    /******************** wish Model ********************/
    public function get_wish_select($filter = false, $order = false, $limit = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->get('tb_designer_wish as wish');

        // echo $this->db->last_query();exit;
        if ($query->num_rows() > 0):
            return $query->result();
        endif;        
        return false;
    }

    public function count_wish($filter = false)
    {
        $this->set_filter($filter);
        return $this->db->count_all_results('tb_designer_wish as wish');
    }

    public function get_wish_by_id($wishId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_filter(array(array('field' => 'wish.is_enable', 'value' => $boolean['enable']), array('field' => 'wish.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('wish.Id', $wishId)->get('tb_designer_wish as wish');

        if ($query->num_rows() > 0):
            $wish = $query->row();

            return $wish;
        endif;

        return false;
    }

    public function insert_wish($post)
    {
        $insert = $this->check_db_data($post);        

        $this->db->insert('tb_designer_wish', $insert);

        return $this->db->insert_id();
    }
    
    /******************** Private Function ********************/
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    // case 'content':
                    //     $data[$field] = check_input_value(html_entity_decode($value));
                    //     break;

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'postId', 'postId' /* post Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}