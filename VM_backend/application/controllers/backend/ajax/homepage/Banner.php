<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** Banner ********************/
    public function get_banner_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));

        $filter = array('like' => array('field' => 'lang.title', 'value' => $search));
        $order = array(array('field' => 'banner.order', 'dir' => 'asc'));


        $this->load->model('homepage/tb_homepage_banner_model', 'banner');
        $bannerList = $this->banner->get_homepage_banner_select($filter, $order, array('limit' => $limit, 'start' => $start), 3);
        $recordsTotal = $this->banner->count_homepage_banner($filter, 3);
        if ($bannerList):
            foreach ($bannerList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                    'preview' => '<div id="preview">' . (!empty($row->bannerImg) ? '<img src="' . base_url($row->bannerImg) . '" width="100%">' : '') . '</div>',
                    'title' => $row->title,
                    'subtitle' => $row->sub_title,
                    'order' => $this->get_order('banner', $row->bannerId, $row->order),
                    'action' => $this->get_button('edit', 'backend/homepage/banner/edit/' . $row->bannerId) . $this->get_button('delete', 'backend/homepage/banner/delete/' . $row->bannerId)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    /******************** End Banner ********************/
}