<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class tb_inspiration_like_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('inspiration_like/'); // 上傳路徑
    }

    /******************** inspiration Model ********************/
    public function get_inspiration_like_select($filter = false, $order = false, $limit = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_inspiration_join();
        $query = $this->db->get('tb_inspiration_like as inspiration_like');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_inspiration_like($filter = false)
    {
        $this->set_filter($filter);
        $this->set_inspiration_join();
        return $this->db->count_all_results('tb_inspiration_like as inspiration_like');
    }

    public function get_inspiration_like_by_id($Id = false)
    {
        $this->set_inspiration_join();       
        $query = $this->db->where('inspiration_like.Id', $Id)->get('tb_inspiration_like as inspiration_like');

        if ($query->num_rows() > 0):
            $inspiration = $query->row();

            return $inspiration;
        endif;

        return false;
    }

    public function insert_inspiration_like($post, $memberId)
    {
        $post['create_at'] =  date("Y-m-d H:i:s");
        // 檢查有沒有點過讚 
        $query = $this->get_inspiration_like_select(array(array('field' => 'inspiration_like.memberId' , 'value' => $memberId), array('field' => 'inspiration_like.inspirationId', 'value' => $post['inspirationId'])), false, false);
        if(!empty($query)){
            $this->delete_inspiration_like($query[0]);
            return true;
        }
        else{
            $this->insert('tb_inspiration_like', $post);
            return $this->db->insert_id();
        }
    }

    public function delete_inspiration_like($inspiration_like)
    {        
        $this->db->delete('tb_inspiration_like', array('Id' => $inspiration_like->Id));
        // echo $this->db->last_query();exit;
        return true;
    }

    /******************** End inspiration Model ********************/

    /******************** Private Function ********************/
    private function set_inspiration_join()
    {
        $this->db->select('inspiration_like.*');
        $this->db->join('tb_inspiration as inspiration', 'inspiration.inspirationId = inspiration_like.inspirationId', 'inner');
        return true;
    }

    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('langList', 'uuid','related'))):
                switch ($field):
                    case 'content':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'designerId', 'cId' /* inspiration Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}