<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_member_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('member/member/'); // 上傳路徑
    }

    /*****member model******/
    public function get_member_select($filter = false, $order = false, $limit = false,$all = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query=$this->db->where('member.is_enable',1)->get('tb_member as member');
        // echo $this->db->last_query();exit;
        if($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_member()
    {
        return $this->db->where('member.is_enable',1)->count_all_results('tb_member as member');
    }

    public function get_member_by_id($memberId = false)
    {
        $query = $this->db->where('member.memberId',$memberId)->get('tb_member as member');
        if($query->num_rows() > 0):
            return $query->row();
        endif;
        
        return false;
    }

    public function insert_member($post)
    {    
        $post['create_at'] = date('Y-m-d H:i:s');
        $insert = $this->check_db_data($post);
        if (isset($_FILES['memberImg']) && !$_FILES['memberImg']['error']):
            $insert['memberImg'] = $this->uploadFile('member', $post['memberId'] . '/', 100);            
        endif;
        $this->insert('tb_member',$insert);
        return $this->db->insert_id();
    }

    public function update_member($member,$post)
    {        
        $update = $this->check_db_data($post);
        if(!empty($post['memberImg'])){
            $decoded = base64_decode(preg_replace('[removed]', '', $post['memberImg']));
            $config['upload_path'] = $this->uploadPath . $member->memberId;
            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';

            $this->load->library('upload', $config);

            $uploadData = $this->upload->data();
            $file_name = $uploadData['full_path']. uniqid('member').'.jpg';
            file_put_contents($file_name,$decoded);
            $update['memberImg'] = $file_name;
        }
        if (isset($_FILES['memberImg']) && !$_FILES['memberImg']['error']):
            $update['memberImg'] = $this->uploadFile('member', $member->memberId . '/', 100);            
        endif;
        
        $this->update('tb_member',$update, array('memberId' => $member->memberId));
        return true;
    }

    public function delete_member($member)
    {
        $this->update_member($member,array('is_enable' => 0));
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