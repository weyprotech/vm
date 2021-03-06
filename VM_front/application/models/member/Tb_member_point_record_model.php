<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_member_point_record_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('member/member_point_record/'); // 上傳路徑
    }

    /*****member_point_record model******/
    public function get_member_point_record_select($filter = false, $order = false, $limit = false,$all = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query=$this->db->where('member_point_record.is_enable',1)->get('tb_member_point_record as member_point_record');
        // echo $this->db->last_query();exit;
        if($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_member_point_record()
    {
        return $this->db->where('member_point_record.is_enable',1)->count_all_results('tb_member_point_record as member_point_record');
    }

    public function get_member_point_record_by_id($member_point_recordId = false)
    {
        $query = $this->db->where('member_point_record.Id',$member_point_recordId)->get('tb_member_point_record as member_point_record');
        if($query->num_rows() > 0):
            return $query->row();
        endif;
        
        return false;
    }

    public function insert_member_point_record($post)
    {    
        $post['create_at'] = date('Y-m-d H:i:s');
        $insert = $this->check_db_data($post);
        $this->insert('tb_member_point_record',$insert);
        return $this->db->insert_id();
    }

    public function update_member_point_record($member_point_record,$post)
    {        
        $update = $this->check_db_data($post);
        
        $this->update('tb_member_point_record',$update, array('Id' => $member_point_record->Id));
        return true;
    }

    public function delete_member_point_record($member_point_record)
    {
        $this->update_member_point_record($member_point_record,array('is_enable' => 0));
        return true;    
    }


    /***資料處理***/
    public function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach($post as $field => $value):
             if (!in_array($field, array('password_re', 'langList', 'uuid'))):
                switch ($field):
                    case "content":
                        $data[$field] = html_entity_decode($value);
                    break;

                    case "password":
                        $value = check_input_value($value);
                        if($value){
                            $data['password'] = md5($this->db->escape_like_str($value));
                        }
                    break;

                    case "email":
                        $data[$field] = $value;
                        break;

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'fId', 'cId', 'aId','account','phone' /* fqa Field */
                        );
                        $data[$field] = check_input_value($this->db->escape_like_str($value), in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /**資料處理***/
}