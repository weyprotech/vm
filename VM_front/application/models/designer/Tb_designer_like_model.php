<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_designer_like_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('designer_like/designer_like/'); // 上傳路徑
    }

    /******************** designer_like Model ********************/
    public function get_designer_like_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        if($langId){
            $this->set_designer_join($langId);
        }
        $query = $this->db->get('tb_designer_like as designer_like');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_designer_like($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        return $this->db->count_all_results('tb_designer_like as designer_like');
    }

    public function get_designer_like_by_id($designer_likeId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_filter(array(array('field' => 'designer_like.is_enable', 'value' => $boolean['enable']), array('field' => 'designer_like.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('designer_like.designer_likeId', $designer_likeId)->get('tb_designer_like as designer_like');
        if ($query->num_rows() > 0):
            $designer_like = $query->row();
            return $designer_like;
        endif;

        return false;
    }

    public function insert_designer_like($post)
    {
        $this->insert('tb_designer_like', $post);
        return $this->db->insert_id();
    }

    public function update_designer_like($designer_like, $post)
    {
        $this->update('tb_designer_like', $post, array('Id' => $designer_like->Id));
        return true;
    }

    public function delete_designer_like($designer_like)
    {
        $this->db->delete('tb_designer_like',array('Id' => $designer_like->Id));        
        return true;
    }

    /******************** Private Function ********************/
    private function set_designer_join($langId)
    {
        $this->db->select('designer.*');
        $this->db->join('tb_designer as designer','designer.designerId = designer_like.designerId','left');
        if ($langId):
            $this->db->select('lang.*');
            $this->db->join('tb_designer_lang as lang', 'lang.designerId = designer.designerId AND lang.langId = ' . $langId);
        endif;
        return true;
    }
}