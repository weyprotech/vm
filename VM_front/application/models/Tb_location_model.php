<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_location_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('location/location/'); // 上傳路徑
    }

    public function get_location_select($filter = false,$order = false,$limit = false){
        $this->db->select('tb_location.*,stree.stree');
        $this->db->join('tb_stree as stree','stree.Id = tb_location.streeId','left');
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->get('tb_location');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function get_location_by_id($id){
        $this->db->select('tb_location.*,stree.stree');
        $this->db->join('tb_stree as stree','stree.Id = tb_location.streeId','left');
        $query = $this->db->where('tb_location.Id',$id)->get('tb_location');
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function update_location($location,$post){
        $this->db->update('tb_location',$post,array('streeId' => $location->streeId));
        return true;
    }

    /***** stree *****/
    public function get_stree_select(){
        $query = $this->db->get('tb_stree');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }
}