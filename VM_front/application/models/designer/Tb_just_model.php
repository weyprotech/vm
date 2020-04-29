<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_just_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('designer/just/'); // 上傳路徑
    }

    /******************** just Model ********************/
    public function get_just_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        if ($langId):
            $this->db->select('just.*,designer.*, designer_lang.name as designer_name');
            $this->db->join('tb_designer as designer','designer.designerId = just.designerId','left');
            $this->db->join('tb_designer_lang as designer_lang','designer_lang.designerId = designer.designerId AND designer_lang.langId ='.$langId,'left');           
        endif;
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('just.is_enable', 1)->get('tb_designer_just_for_you as just');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_just($filter = false, $langId = false)
    {
        if ($langId):
            $this->db->select('just.*,designer.*, designer_lang.name as designer_name');
            $this->db->join('tb_designer as designer','designer.designerId = just.designerId','left');
            $this->db->join('tb_designer_lang as designer_lang','designer_lang.designerId = designer.designerId AND designer_lang.langId ='.$langId,'left');            
        endif;
        $this->set_filter($filter);
        return $this->db->where('just.is_enable', 1)->count_all_results('tb_designer_just_for_you as just');
    }

    public function get_just_by_id($justId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        if ($langId):
            $this->db->select('just.*,designer.*, designer_lang.name as designer_name');
            $this->db->join('tb_designer as designer','designer.designerId = just.designerId','left');
            $this->db->join('tb_designer_lang as designer_lang','designer_lang.designerId = designer.designerId AND designer_lang.langId ='.$langId,'left');            
        endif;
        $this->set_filter(array(array('field' => 'just.is_enable', 'value' => $boolean['enable']), array('field' => 'just.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('just.Id', $justId)->get('tb_designer_just_for_you as just');

        if ($query->num_rows() > 0):
            $just = $query->row();

            return $just;
        endif;

        return false;
    }

    public function insert_just($just)
    {        
        $insert = $this->check_db_data($just);        

        $this->db->insert('tb_designer_just_for_you', $insert);

        return $this->db->insert_id();
    }

    public function update_just($just, $update)
    {
        $update = $this->check_db_data($update);

        $this->db->update('tb_designer_just_for_you', $update, array('Id' => $just->Id));
        return true;
    }

    public function delete_just($just)
    {
        $this->update_just($just, array('is_enable' => 0));
        return true;
    }

    /******************** End just Model ********************/

    /******************** Private Function ********************/
    /*************** 處理資料 ***************/
    private function check_db_data($just)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($just as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    // case 'content':
                    //     $data[$field] = check_input_value(html_entity_decode($value));
                    //     break;

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'justId', 'justId' /* just Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}