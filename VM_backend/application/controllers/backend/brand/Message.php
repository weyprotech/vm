<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message extends Backend_Controller
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
        $this->load->model('brand/tb_brand_message_model', 'message_model');
        $this->load->model('designer/tb_designer_model','designer_model');
        $this->load->model('tb_location_model','location_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index($brandId)
    {
        $data = array(
            'brandId' => $brandId
        );

        $this->get_view('index', $data);
    }

    public function edit($messageId = false)
    {
        if(!$row = $this->message_model->get_brand_message_by_id($messageId)):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/brand/message');
        endif;

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->message_model->update_brand_message($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/brand/message/index/'.$row->brandId . $this->query);
                endif;
            endif;

            redirect('backend/brand/message/edit/' . $row->Id . $this->query);
        endif;

        $data = array(
            'row' => $row
        );

        $this->get_view('edit', $data);
    }
    
    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/brand/message/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}