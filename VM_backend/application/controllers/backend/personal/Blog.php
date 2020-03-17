<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Backend_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!designer_logged_in()) {
            redirect('backend/personal/panel/login');
        }
    }

    public function index()
    {
        $designerId = $this->session->userdata('designerId');
        if (!$row = $this->designer_model->get_designer_by_id($designerId,false, array('enable' => false, 'visible' => false))) {
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/blog');
        }
        if ($post = $this->input->post(null, true)) {
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']) {
                $this->set_active_status('danger', 'Date has been changed');
            }
            else {
                if ($this->designer_model->update_designer($row, $post)) {
                    $this->set_active_status('success', 'Success');
                }
                else {
                    // $this->set_active_status('danger', '此帳號、密碼已被使用!');
                }

                if ($this->input->get('back', true)) {
                    // redirect('backend/personal/blog');
                }
            }
            redirect('backend/personal/blog');

            // redirect('backend/personal/blog/edit/' . $userId);
        }
        $data = array(
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($userId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->blog->get_user_by_id($userId, array('enable' => true, 'visible' => false))) {
            $this->set_active_status('danger', 'The data does not exist!');
        }
        else {
            $this->blog->delete_user($row);
            $this->set_active_status('success', 'Success');
        }

        redirect('backend/blog');
    }

    /******************** End Group Function ********************/

    /******************** Public Function ********************/
    public function get_group_auth()
    {
        if ($this->check_action_auth($this->menuId, 'edit')) {// Check Auth
            $groupId = $this->input->post('groupId', true);
            $group = $this->blog->get_group_by_id($groupId);

            echo $this->load->view('backend/blog/_menuList', array('menuId' => 0, 'menuList' => $this->menuList, 'auth' => ($group && !empty($group->auth)) ? json_decode($group->auth, true) : false), true);
        }
    }
    /******************** End Public Function ********************/

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/personal/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content,'VETRINA MIA - '.$data['row']->langList[3]->name), false);
    }
    /******************** End Private Function ********************/
}