<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends Backend_Controller
{
    public function index()
    {
        if (!designer_logged_in()) {
            redirect('backend/personal/panel/login');
        }
        // $this->load->view('backend/index', $this->get_page_nav(''), false);
    }

    public function login()
    {
        $this->load->view('backend/personal/login');
    }

    public function logindo()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);        
        if($username != null && $password != null){
            if ($designer = $this->designer_model->get_designer_select(array(array('field' => 'designer.account','value' => $username),array('field' => 'designer.password','value' => $password)),false,false,3)) {

                $this->session->set_userdata(
                    array(
                        'designer' => 'Y',
                        'is_manager' => 0,
                        'designerId' => $designer[0]->designerId,
                        'designerName' => $designer[0]->name,
                        'designer_logged_in' => true
                    )
                );
                redirect('backend/personal/blog');
            }       
            else {
                js_warn('Account / password error');
                redirect('backend/personal/panel/login');
            }
        }else{
            js_warn('Account / password must not be empty');
            redirect('backend/personal/panel/login');
        }
        

        // redirect('backend/personal/panel/login', 'refresh');
    }

    public function logout()
    {
        $this->session->set_userdata(array(
            'is_logged_in' => '',
            'designer' => '',
            'is_manager' => '',
            'designerId' => '',
            'designerName' => '',
            'designer_logged_in' => ''
        ));
        redirect('backend/personal/panel/login');
    }
}