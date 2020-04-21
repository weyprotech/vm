<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_contact_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('contact/contact/'); // 上傳路徑
    }

    /******************** contact Model ********************/
    public function get_contact_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('contact.is_enable', 1)->get('tb_contact as contact');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_contact($filter = false, $langId = false)
    {        
        $this->set_filter($filter);
        return $this->db->where('contact.is_enable', 1)->count_all_results('tb_contact as contact');
    }

    public function get_contact_by_id($contactId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {        
        $this->set_filter(array(array('field' => 'contact.is_enable', 'value' => $boolean['enable']), array('field' => 'contact.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('contact.contactId', $contactId)->get('tb_contact as contact');

        if ($query->num_rows() > 0):
            $contact = $query->row();

            return $contact;
        endif;

        return false;
    }

    public function insert_contact($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $insert = $this->check_db_data($post);

        $this->db->insert('tb_contact', $insert);
        return true;
    }

    public function update_contact($contact, $post)
    {
        $update = $this->check_db_data($post);

        $this->db->update('tb_contact', $update, array('contactId' => $contact->contactId));
        return true;
    }

    public function delete_contact($contact)
    {
        $this->update_contact($contact, array('is_enable' => 0));
    }

    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('mainId', 'imageOrder', 'langList', 'uuid','size','image_list_length'))):
                switch ($field):
                    case 'minorId':
                        $data['cId'] = check_input_value($value, true);
                        break;

                    case 'detail':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;

                    case 'description':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;
                    
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'contactId', 'cId', 'pId', /* contact Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }

    private function set_contact_join($langId)
    {
        $this->db->select('contact.*');
        if ($langId):
            $this->db->select('lang.*');
            $this->db->join('tb_contact_lang as lang', 'lang.pId = contact.contactId AND lang.langId = ' . $langId, 'left');          
        endif;

        return true;
    }    
    /******************** End Private Function ********************/
}