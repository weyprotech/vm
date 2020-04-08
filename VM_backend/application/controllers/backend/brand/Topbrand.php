<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Topbrand extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->check_action_auth($this->prevId, 'view', true); // Check Auth
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->load->model('brand/tb_brand_model', 'brand_model');
        $this->load->model('brand/tb_topbrand_model', 'topbrand_model');

        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $brandList = $this->brand_model->get_brand_select(array(array('field' => 'brand.is_visible','value' => 1)),false,false,$this->langId);
        $topList = $this->topbrand_model->get_topbrand_select(false,array(array('field' => 'brand_top.Id','dir' => 'asc')),false,$this->langId);
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth
            $this->topbrand_model->update_topbrand($post['data']);
            $this->set_active_status('success', 'Success');

            redirect('backend/brand/topbrand/' . $this->query);
        endif;

        $data = array(
            'topList' => $topList,
            'brandList' => $brandList
        );

        $this->get_view('index', $data);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/brand/top/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}