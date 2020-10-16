<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Money extends Backend_Controller
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

        $this->load->model('money/tb_money_model', 'money_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth

        if($post = $this->input->post(null,true)){
            // print_r($post);exit;
            $this->money_model->insert_money($post);
            if($this->input->get('back',true)){
                redirect("backend/money/money/");
            }
            redirect('backend/money/money/edit/' . $moneyId . $this->query);
        }
        $this->get_view('add');
    }

    public function edit($moneyId = false)
    {
        if (!$row = $this->money_model->get_money_by_id($moneyId)):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/money/money');
        endif;        

        if ($post = $this->input->post(null, true)):    
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->money_model->update_money($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/money/money' . $this->query);
                endif;
            endif;

            redirect('backend/money/money/edit/' . $moneyId . $this->query);
        endif;
        
        $data = array(
            'moneyId' => $moneyId,
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($moneyId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->money_model->get_money_by_id($moneyId)):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->money_model->delete_money($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/money/money' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/money/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}