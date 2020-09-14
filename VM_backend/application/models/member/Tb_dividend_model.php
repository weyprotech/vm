<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_dividend_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('member/dividend/'); // 上傳路徑
    }

    /*****dividend model******/
    public function get_dividend_select($filter = false, $order = false, $limit = false,$all = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query=$this->db->where('dividend.is_enable',1)->get('tb_dividend_record as dividend');
        // echo $this->db->last_query();exit;
        if($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_dividend()
    {
        return $this->db->where('dividend.is_enable',1)->count_all_results('tb_dividend_record as dividend');
    }

    public function get_dividend_by_id($dividendId = false)
    {
        $query = $this->db->where('dividend.dividendId',$dividendId)->get('tb_dividend_record as dividend');
        if($query->num_rows() > 0):
            return $query->row();
        endif;
        
        return false;
    }

    public function insert_dividend($post)
    {    
        $post['create_at'] = date('Y-m-d H:i:s');
        $insert = $this->check_db_data($post);
        if (isset($_FILES['dividendImg']) && !$_FILES['dividendImg']['error']):
            $insert['dividendImg'] = $this->uploadFile('dividend', $post['dividendId'] . '/', 100);            
        endif;
        $this->insert('tb_dividend',$insert);
        return $this->db->insert_id();
    }

    public function update_dividend($dividend,$post)
    {        
        $update = $this->check_db_data($post);
        if(!empty($post['dividendImg'])){
            $decoded = base64_decode(preg_replace('[removed]', '', $post['dividendImg']));
            $config['upload_path'] = $this->uploadPath . $dividend->dividendId;
            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';

            $this->load->library('upload', $config);

            $uploadData = $this->upload->data();
            $this->checkUploadPath($dividend->dividendId); // 上傳路徑

            $file_name = $uploadData['full_path']. uniqid('dividend').'.jpg';
            file_put_contents($file_name,$decoded);
            $update['dividendImg'] = $file_name;
        }
        if (isset($_FILES['dividendImg']) && !$_FILES['dividendImg']['error']):
            $update['dividendImg'] = $this->uploadFile('dividend', $dividend->dividendId . '/', 100);            
        endif;
        
        $this->update('tb_dividend',$update, array('dividendId' => $dividend->dividendId));
        return true;
    }

    public function delete_dividend($dividend)
    {
        $this->update_dividend($dividend,array('is_enable' => 0));
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