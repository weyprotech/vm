<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_message_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('designer/message/'); // 上傳路徑
    }

    /******************** message Model ********************/
    public function get_message_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        if ($langId):
            $this->db->select('message.*,designer.*, designer_lang.name as designer_name');
            $this->db->join('tb_designer as designer','designer.designerId = message.designerId','left');
            $this->db->join('tb_designer_lang as designer_lang','designer_lang.designerId = designer.designerId AND designer_lang.langId ='.$langId,'left');           
        endif;
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('message.is_enable', 1)->get('tb_designer_message as message');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_message($filter = false, $langId = false)
    {
        if ($langId):
            $this->db->select('message.*,designer.*, designer_lang.name as designer_name');
            $this->db->join('tb_designer as designer','designer.designerId = message.designerId','left');
            $this->db->join('tb_designer_lang as designer_lang','designer_lang.designerId = designer.designerId AND designer_lang.langId ='.$langId,'left');            
        endif;
        $this->set_filter($filter);
        return $this->db->where('message.is_enable', 1)->count_all_results('tb_designer_message as message');
    }

    public function get_message_by_id($messageId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        if ($langId):
            $this->db->select('message.*,designer.*, designer_lang.name as designer_name');
            $this->db->join('tb_designer as designer','designer.designerId = message.designerId','left');
            $this->db->join('tb_designer_lang as designer_lang','designer_lang.designerId = designer.designerId AND designer_lang.langId ='.$langId,'left');            
        endif;
        $this->set_filter(array(array('field' => 'message.is_enable', 'value' => $boolean['enable']), array('field' => 'message.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('message.Id', $messageId)->get('tb_designer_message as message');

        if ($query->num_rows() > 0):
            $message = $query->row();

            return $message;
        endif;

        return false;
    }

    public function insert_message($message)
    {
        $message['order'] = $this->count_message(array(array('field' => 'message.messageId','value' => $message['messageId'])))+1;
        $insert = $this->check_db_data($message);        

        $this->db->insert('tb_designer_message', $insert);

        return $this->db->insert_id();
    }

    public function update_message($message, $update)
    {
        $update = $this->check_db_data($update);

        $this->db->update('tb_designer_message', $update, array('Id' => $message->Id));
        return true;
    }

    public function delete_message($message)
    {
        $this->update_message($message, array('is_enable' => 0));
        return true;
    }

    /******************** End message Model ********************/

    /******************** Private Function ********************/
    /*************** 處理資料 ***************/
    private function check_db_data($message)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($message as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    // case 'content':
                    //     $data[$field] = check_input_value(html_entity_decode($value));
                    //     break;

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'messageId', 'messageId' /* message Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}