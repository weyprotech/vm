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
        $inspirationId = $this->input->get('inspirationId',true);
        $filter = array(array('field' => 'banner.inspirationId', 'value' => $inspirationId));
        $order = array(array('field' => 'banner.order', 'dir' => 'asc'));

        $this->load->model('inspiration/tb_inspiration_banner_model', 'banner');
        $bannerList = $this->banner->get_inspiration_banner_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->banner->count_inspiration_banner($filter, $this->langId);
        if ($bannerList):
            foreach ($bannerList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                    'preview' => '<div id="preview">' . (!empty($row->bannerImg) ? '<img src="' . base_url($row->bannerImg) . '" width="100%">' : '') . '</div>',
                    'order' => $this->get_order('banner', $row->bannerId, $row->order),
                    'action' => $this->get_button('edit', 'backend/inspiration/banner/edit/' . $row->bannerId) . $this->get_button('delete', 'backend/inspiration/banner/delete/' . $row->bannerId)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    /******************** End Banner ********************/
}