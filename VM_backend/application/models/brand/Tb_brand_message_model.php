<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_brand_message_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('brand/message/'); // 上傳路徑
    }

    /******************** brand Model ********************/
    public function get_brand_message_select($filter = false, $order = false, $limit = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);

        $query = $this->db->get('tb_brand_message as message');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_brand_message($filter = false)
    {
        $this->set_filter($filter);

        return $this->db->count_all_results('tb_brand_message as message');
    }

    public function get_brand_message_by_id($messageId = false)
    {
        $query = $this->db->where('message.Id', $messageId)->get('tb_brand_message as message');

        if ($query->num_rows() > 0):
            $message = $query->row();

            return $message;
        endif;

        return false;
    }

    public function update_brand_message($message, $post)
    {
        $update = $this->check_db_data($post);

        $this->update('tb_brand_message', $update, array('Id' => $message->Id));
        return true;
    }

    /******************** End brand Model ********************/

    /******************** Private Function ********************/

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