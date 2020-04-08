<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Topdesigner extends Backend_Controller
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

        $this->load->model('designer/tb_designer_model', 'designer_model');
        $this->load->model('designer/tb_topdesigner_model', 'topdesigner_model');

        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $designerList = $this->designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1)),false,false,$this->langId);
        $topList = $this->topdesigner_model->get_topdesigner_select(false,array(array('field' => 'designer_top.Id','dir' => 'asc')),false,$this->langId);
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth
            $this->topdesigner_model->update_topdesigner($post['data']);
            $this->set_active_status('success', 'Success');

            redirect('backend/designer/topdesigner/' . $this->query);
        endif;

        $data = array(
            'topList' => $topList,
            'designerList' => $designerList
        );

        $this->get_view('index', $data);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/designer/top/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}