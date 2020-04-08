<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tb_homepage_banner_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('homepage/homepage_banner/'); // 上傳路徑
    }

    /******************** Banner Model ********************/
    public function get_homepage_banner_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_banner_join($langId);
        $query = $this->db->where('banner.is_enable', 1)->get('tb_homepage_banner as banner');

        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_homepage_banner($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        return $this->db->where('banner.is_enable', 1)->count_all_results('tb_homepage_banner as banner');
    }

    public function get_homepage_banner_by_id($bannerId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_filter(array(array('field' => 'banner.is_enable', 'value' => $boolean['enable']), array('field' => 'banner.is_visible', 'value' => $boolean['visible'])));
        $this->set_banner_join($langId);
        $query = $this->db->where('banner.bannerId', $bannerId)->get('tb_homepage_banner as banner');
        if($query->num_rows() > 0){ 
            $banner = $query->row();
            if (!$langId):
                $banner->langList = $this->get_banner_lang_select(array(array('field' => 'bId', 'value' => $bannerId)));
            endif;

            return $banner;
        }
        return false;
    }

    public function insert_homepage_banner($post)
    {
        $post['order'] = $this->count_homepage_banner() + 1;
        $post['create_at'] = date('Y-m-d H:i:s');
        $insert = $this->check_db_data($post);
        if (isset($_FILES['bannerImg']) && !$_FILES['bannerImg']['error']):
            $insert['bannerImg'] = $this->uploadFile('banner', $post['bannerId'] . '/', 1920);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_banner_lang($post['bannerId'], $post['langList']);
        endif;

        $this->db->insert('tb_homepage_banner', $insert);
        return $this->db->insert_id();
    }

    public function update_homepage_banner($banner, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($_FILES['bannerImg']) && !$_FILES['bannerImg']['error']):
            $update['bannerImg'] = $this->uploadFile('banner', $banner->bannerId . '/', 1920);
            @unlink($banner->bannerImg);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_banner_lang($banner->bannerId, $post['langList']);
        endif;

        $this->db->update('tb_homepage_banner', $update, array('bannerId' => $banner->bannerId));
        return true;
    }

    public function delete_homepage_banner($banner)
    {
        $this->update_homepage_banner($banner, array('is_enable' => 0));
        return $this->reorder_banner();
    }

    /*************** banner Lang Model ***************/
    private function get_banner_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_homepage_banner_lang');

        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_banner_lang($bannerId, $update)
    {
        $this->db->where('bId', $bannerId)->update_batch('tb_homepage_banner_lang', $update, 'langId');
        
        $langList = $this->get_banner_lang_select(array(array('field' => 'bId', 'value' => $bannerId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_homepage_banner_lang', $insert);
        endif;

        return true;
    }
    /*************** End designer Lang Model ***************/

    /*************** 重新排序 ***************/
    private function reorder_banner()
    {
        $result = $this->get_homepage_banner_select(false, array(array('field' => 'banner.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('bannerId' => $row->bannerId, 'order' => $i + 1));
            endforeach;
            return $this->db->update_batch('tb_homepage_banner', $order, 'bannerId');
        endif;

        return true;
    }
    /******************** End Banner Model ********************/

    /******************** Private Function ********************/
    private function set_banner_join($langId)
    {
        $this->db->select('banner.*');
        if ($langId):
            $this->db->select('lang.title,lang.sub_title,lang.content');
            $this->db->join('tb_homepage_banner_lang as lang', 'lang.bId = banner.bannerId AND lang.langId = ' . $langId);
        endif;
        return true;
    }
    
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