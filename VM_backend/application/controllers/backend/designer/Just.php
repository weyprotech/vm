<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class just extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('designer/tb_just_model', 'just_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index($designerId)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index',array('designerId' => $designerId));
    }    

    public function view($justId = false)
    {

        if (!$row = $this->just_model->get_just_by_id($justId, 3, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/just');
        endif;

        if ($just = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $just['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                unset($just['dt_basic_length']);
                $this->just_model->update_just($row, $just);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/designer/just/index/'.$row->designerId . $this->query);
                endif;
            endif;
            redirect('backend/designer/just/view/' . $justId . $this->query);
        endif;

        $data = array(
            'row' => $row,
            'justId' => $justId,
            'designerId' => $row->designerId
        );

        $this->get_view('view', $data);
    }

    public function delete($justId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->just_model->get_just_by_id($justId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $designerId = $row->designerId;
            $this->just_model->delete_just($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/designer/just/index/'.$designerId . $this->query);
    }

    public function save($designerId)
    {
        if ($order = $this->input->just('justOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_designer_just', $order, 'justId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/designer/just/index/'.$designerId . $this->query);
    }
    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/designer/just/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}