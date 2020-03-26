<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Set_website_color extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('homepage/tb_set_website_color_model', 'set_website_color_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function edit()
    {
        $row = $this->set_website_color_model->get_set_website_color();
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth
            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->set_website_color_model->update_set_website_color($post);
                $this->set_active_status('success', 'Success');                
            endif;

            redirect('backend/homepage/set_website_color/edit' . $this->query);
        endif;
        $data = array(            
            'row' => $row
        );

        $this->get_view('edit', $data);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/homepage/set_website_color/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}