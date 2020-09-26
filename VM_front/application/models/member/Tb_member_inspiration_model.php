<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_member_inspiration_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('member/member_inspiration/'); // 上傳路徑
    }

    /*****member_inspiration model******/
    public function get_member_inspiration_select($filter = false, $order = false, $limit = false,$langId = 3)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_inspiration_join($langId);
        $query=$this->db->get('tb_member_inspiration as member_inspiration');
        // echo $this->db->last_query();exit;
        if($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_member_inspiration()
    {
        return $this->db->where('member_inspiration.is_enable',1)->count_all_results('tb_member_inspiration as member_inspiration');
    }

    public function get_member_inspiration_by_id($member_inspirationId = false,$langId = 3)
    {
        $this->set_inspiration_join($langId);
        $query = $this->db->where('member_inspiration.Id',$member_inspirationId)->get('tb_member_inspiration as member_inspiration');
        if($query->num_rows() > 0):
            return $query->row();
        endif;
        
        return false;
    }

    public function insert_member_inspiration($post)
    {    
        $post['create_at'] = date('Y-m-d H:i:s');
        $insert = $this->check_db_data($post);
        $this->insert('tb_member_inspiration',$insert);
        return $this->db->insert_id();
    }

    public function update_member_inspiration($member_inspiration,$post)
    {        
        $update = $this->check_db_data($post);
        
        $this->update('tb_member_inspiration',$update, array('Id' => $member_inspiration->Id));
        return true;
    }

    public function delete_member_inspiration($member_inspiration)
    {
        $this->db->delete('tb_product_like',array('Id' => $member_inspiration->Id));
        return true;    
    }

    private function set_inspiration_join($langId)
    {
        $this->db->select('member_inspiration.*,tb_inspiration.inspirationId as inspiration_inspirationId,tb_inspiration.inspirationImg');
        if ($langId):
            $this->db->select('lang.title,lang.Content');
            $this->db->join('tb_inspiration','tb_inspiration.inspirationId = member_inspiration.inspirationId','left');
            $this->db->join('tb_inspiration_lang as lang', 'lang.iId = member_inspiration.inspirationId AND lang.langId = ' . $langId);
        endif;
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