<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dividend extends Backend_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()) {
            redirect('admin');
        }
        $this->load->model('member/tb_dividend_model','dividend_model');
    }

    public function index()
    {
        if (!$this->check_action_auth($this->prevId, 'view')) {
            return $this->load->view('backend/index', $this->get_page_nav(), false);
        }

        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index');
    }

    // public function add()
    // {
    //     $this->check_action_auth($this->menuId, 'add', true); // Check Auth
    //     $dividendId = uniqid();
    //     if($post = $this->input->post(null,true)){
    //         $post['dividendId'] = $dividendId;
    //         $this->dividend_model->insert_dividend($post);
    //         if($this->input->get('back',true)){
    //             redirect("backend/member/dividend/index/");
    //         }
    //         redirect('backend/member/dividend/edit/' . $dividendId);
    //     }
    //     $countryList = get_all_country();
    //     $data = array(
    //         'countryList' => $countryList,
    //         'dividendId' => $dividendId
    //     );
    //     $this->get_view('add',$data);
    // }

    public function delete($dividendId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->dividend_model->get_dividend_by_id($dividendId, array('enable' => true, 'visible' => false))) {
            $this->set_active_status('danger', 'The data does not exist!');
        }
        else {
            $this->dividend_model->delete_dividend($row);
            $this->set_active_status('success', 'Success');
        }

        redirect('backend/member/dividend');
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/member/dividend_record/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
    /******************** End Private Function ********************/
}