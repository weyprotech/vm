<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tb_inspiration_banner_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('inspiration/inspiration_banner/'); // 上傳路徑
    }

    /******************** Banner Model ********************/
    public function get_inspiration_banner_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('banner.is_enable', 1)->get('tb_inspiration_banner as banner');

        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_inspiration_banner($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        return $this->db->where('banner.is_enable', 1)->count_all_results('tb_inspiration_banner as banner');
    }

    public function get_inspiration_banner_by_id($bannerId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_filter(array(array('field' => 'banner.is_enable', 'value' => $boolean['enable']), array('field' => 'banner.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('banner.bannerId', $bannerId)->get('tb_inspiration_banner as banner');
        if($query->num_rows() > 0){
            $banner = $query->row();
            return $banner;
        }
        return false;
    }
}