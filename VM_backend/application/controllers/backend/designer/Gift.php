<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gift extends Backend_Controller
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
        $this->load->model('designer/tb_gift_designer_model','gift_designer_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->get_view('index');
    }

    public function edit($giftId = false)
    {
        if (!$row = $this->gift_designer_model->get_gift_designer_by_id($giftId)):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/designer/designer_gift');
        endif;
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->gift_designer_model->update_gift_designer($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/designer/designer_gift' . $this->query);
                endif;
            endif;

            redirect('backend/designer/designer/edit/' . $giftId . $this->query);
        endif;

        $data = array(
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/designer/gift/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}