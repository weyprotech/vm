<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_gift_designer_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('member/gift_designer/'); // 上傳路徑
    }

    /*****gift_designer model******/
    public function get_gift_designer_select($filter = false, $order = false, $limit = false,$langId = 3)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_product_join($langId);
        $query=$this->db->where('gift_designer.is_enable',1)->get('tb_gift_designer as gift_designer');
        // echo $this->db->last_query();exit;
        if($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_gift_designer($filter = false,$langId = 3)
    {
        $this->set_filter($filter);
        $this->set_product_join($langId);
        return $this->db->where('gift_designer.is_enable',1)->count_all_results('tb_gift_designer as gift_designer');
    }

    public function get_gift_designer_by_id($gift_designerId = false, $langId = 3)
    {
        $this->set_product_join($langId);
        $query = $this->db->where('gift_designer.Id',$gift_designerId)->get('tb_gift_designer as gift_designer');
        if($query->num_rows() > 0):
            return $query->row();
        endif;
        
        return false;
    }

    public function insert_gift_designer($post)
    {    
        $post['create_at'] = date('Y-m-d H:i:s');
        $post['Id'] = uniqid();
        $insert = $this->check_db_data($post);
        $this->insert('tb_gift_designer',$insert);
        return $post['Id'];
    }

    public function update_gift_designer($gift_designer,$post)
    {        
        $update = $this->check_db_data($post);
        $this->update('tb_gift_designer',$update, array('Id' => $gift_designer->Id));
        return true;
    }

    public function delete_gift_designer($gift_designer)
    {
        $this->update_gift_designer($gift_designer,array('is_enable' => 0));
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

    /*** join ***/
    private function set_product_join($langId){
        $this->db->select('gift_designer.*,designer.*,lang.name');
        $this->db->join('tb_designer as designer', 'designer.designerId = gift_designer.designerId','left');
        $this->db->join('tb_designer_lang as lang', 'lang.designerId = gift_designer.designerId AND lang.langId = ' . $langId, 'left');
    }
}