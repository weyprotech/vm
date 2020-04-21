<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_feedback_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('feedback/feedback/'); // 上傳路徑
    }

    /******************** feedback Model ********************/
    public function get_feedback_select($filter = false, $order = false, $limit = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('feedback.is_enable', 1)->get('tb_feedback as feedback');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_feedback($filter = false)
    {        
        $this->set_filter($filter);
        return $this->db->where('feedback.is_enable', 1)->count_all_results('tb_feedback as feedback');
    }

    public function get_feedback_by_id($feedbackId = false)
    {        
        $query = $this->db->where('feedback.Id', $feedbackId)->get('tb_feedback as feedback');

        if ($query->num_rows() > 0):
            $feedback = $query->row();
            return $feedback;
        endif;

        return false;
    }

    public function insert_feedback($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $insert = $this->check_db_data($post);

        $this->db->insert('tb_feedback', $insert);
        return true;
    }

    public function update_feedback($feedback, $post)
    {
        $update = $this->check_db_data($post);

        $this->db->update('tb_feedback', $update, array('Id' => $feedback->Id));
        return true;
    }

    public function delete_feedback($feedback)
    {
        $this->update_feedback($feedback, array('is_enable' => 0));
    }


    /*************** End feedback Lang Model ***************/    
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('mainId', 'imageOrder', 'langList', 'uuid','size','image_list_length'))):
                switch ($field):
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'feedbackId', 'cId', 'pId', /* feedback Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}