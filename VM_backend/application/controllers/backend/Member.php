<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Backend_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()) {
            redirect('admin');
        }
        $this->load->model('tb_member_model','member_model');
    }

    public function index()
    {
        if (!$this->check_action_auth($this->prevId, 'view')) {
            return $this->load->view('backend/index', $this->get_page_nav(), false);
        }

        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $memberId = uniqid();
        if($post = $this->input->post(null,true)){
            $post['memberId'] = $memberId;
            $this->member_model->insert_member($post);
            if($this->input->get('back',true)){
                redirect("backend/member/index/");
            }
            redirect('backend/member/edit/' . $memberId);
        }
        $countryList = get_all_country();
        $data = array(
            'countryList' => $countryList,
            'memberId' => $memberId
        );
        $this->get_view('add',$data);
    }

    public function edit($memberId)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        if (!$row = $this->member_model->get_member_by_id($memberId, array('enable' => false, 'visible' => false))) {
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/admin');
        }

        if ($post = $this->input->post(null, true)) {
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']) {
                $this->set_active_status('danger', 'Date has been changed');
            }
            else {
                if ($this->member_model->update_member($row, $post)) {
                    $this->set_active_status('success', 'Success');
                }
                else {
                    $this->set_active_status('danger', 'This account and password have been used');
                }

                if ($this->input->get('back', true)) {
                    redirect('backend/member');
                }
            }

            redirect('backend/member/edit/' . $memberId);
        }
        $countryList = get_all_country();

        $data = array(
            'row' => $row,
            'countryList' => $countryList            
        );

        $this->get_view('edit', $data);
    }

    public function delete($memberId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->member_model->get_member_by_id($memberId, array('enable' => true, 'visible' => false))) {
            $this->set_active_status('danger', 'The data does not exist!');
        }
        else {
            $this->member_model->delete_member($row);
            $this->set_active_status('success', 'Success');
        }

        redirect('backend/member');
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/member/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
    /******************** End Private Function ********************/
}