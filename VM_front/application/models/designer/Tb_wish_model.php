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
    public function insert_wish($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
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