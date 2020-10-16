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
    public function get_brand_message_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_join($langId);
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

    public function insert_brand_message($post)
    {
        $post['create_at'] =  date("Y-m-d H:i:s");
        $insert = $this->check_db_data($post);

        $this->insert('tb_brand_message', $insert);
        return $this->db->insert_id();
    }

    /******************** End brand Model ********************/

    /******************** Private Function ********************/
    /***********************Set Join*************************/
    private function set_join($langId = false)
    {
        $this->db->select('message.*, member.first_name, member.last_name, member.memberImg as memberImg, brand.brandImg as brandImg');
        $this->db->join('tb_member as member','member.memberId = message.memberId','inner');
        $this->db->join('tb_brand as brand', 'brand.brandId = message.brandId', 'inner');
        if($langId){
            $this->db->select("brand_lang.name");
            $this->db->join('tb_brand_lang as brand_lang', 'brand_lang.brandId = brand.brandId AND brand_lang.langId = ' . $langId, 'inner');
        }
    
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