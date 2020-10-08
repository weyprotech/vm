<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wish extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('designer/tb_wish_model', 'wish_model');
        $this->load->model('member/tb_member_model', 'member_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index($designerId)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth
        $this->get_view('index',array('designerId' => $designerId));
    }

    public function view($wishId = false)
    {
        if (!$row = $this->wish_model->get_wish_by_id($wishId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/wish');
        endif;
        $member = $this->member_model->get_member_by_id($row->memberId);
        // print_r($member);exit;
        $data = array(
            'row' => $row,
            'name' => $member->first_name . " " . $member->last_name,
            'wishId' => $wishId,
            'designerId' => $row->designerId
        );

        $this->get_view('view', $data);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/designer/wish/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}