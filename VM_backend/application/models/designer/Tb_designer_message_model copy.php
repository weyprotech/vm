<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_designer_message_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('designer/designer/'); // 上傳路徑
    }

    /******************** designer Model ********************/
    public function get_designer_message_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_designer_join($langId);
        $query = $this->db->get('tb_designer_post_message as message');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_designer_message($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_designer_join($langId);
        return $this->db->count_all_results('tb_designer_post_message as message');
    }

    public function get_designer_message_by_id($Id = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_designer_join($langId);
        $query = $this->db->where('message.Id', $Id)->get('tb_designer_post_message as message');

        if ($query->num_rows() > 0):
            return $query->row();
        endif;

        return false;
    }

    public function insert_designer_message($post)
    {

        $insert = $this->check_db_data($post);    

        $this->insert('tb_designer_post_message', $insert);
        return $this->db->insert_id();
    }

    public function update_designer_message($message, $post)
    {
        $update = $this->check_db_data($post);

        $this->update('tb_designer_post_message', $update, array('Id' => $message->Id));
        return true;
    }

    public function delete_designer_message($message)
    {
        $this->db->delete('tb_designer_post_message',array('Id' => $message->Id));
        return true;
    }

    /******************** End designer Model ********************/
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
                            'designerId', 'cId' /* designer Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}