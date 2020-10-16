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

    public function insert_inspiration_banner($post)
    {
        $post['order'] = $this->count_inspiration_banner(array(array('field' => 'banner.inspirationId','value' => $post['inspirationId']))) + 1;
        $post['create_at'] = date('Y-m-d H:i:s');
        $insert = $this->check_db_data($post);
        if (isset($_FILES['bannerImg']) && !$_FILES['bannerImg']['error']):
            $insert['bannerImg'] = $this->uploadFile('banner', $post['bannerId'] . '/', 1920);
        endif;
        $this->db->insert('tb_inspiration_banner', $insert);
        return $this->db->insert_id();
    }

    public function update_inspiration_banner($banner, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($_FILES['bannerImg']) && !$_FILES['bannerImg']['error']):
            $update['bannerImg'] = $this->uploadFile('banner', $banner->bannerId . '/', 1920);
            @unlink($banner->bannerImg);
        endif;


        $this->db->update('tb_inspiration_banner', $update, array('bannerId' => $banner->bannerId));
        return true;
    }

    public function delete_inspiration_banner($banner)
    {
        $this->update_inspiration_banner($banner, array('is_enable' => 0));
        return $this->reorder_banner();
    }

    /*************** 重新排序 ***************/
    private function reorder_banner()
    {
        $result = $this->get_inspiration_banner_select(false, array(array('field' => 'banner.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('bannerId' => $row->bannerId, 'order' => $i + 1));
            endforeach;
            return $this->db->update_batch('tb_inspiration_banner', $order, 'bannerId');
        endif;

        return true;
    }
    /******************** End Banner Model ********************/

    /******************** Private Function ********************/
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'bannerId', 'bId'/* Banner Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}