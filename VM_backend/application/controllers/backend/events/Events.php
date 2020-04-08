<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events extends Backend_Controller
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

        $this->load->model('events/tb_events_model', 'events_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $eventId = uniqid();
    
        if($post = $this->input->post(null,true)){
            $this->events_model->insert_events($post);
            $eventId = $post['eventId'];
            if($this->input->get('back',true)){
                redirect("backend/events/events/");
            }
            redirect('backend/events/events/edit/' . $eventId . $this->query);
        }
        $this->get_view('add',array('eventId' => $eventId));
    }

    public function edit($eventId = false)
    {
        if (!$row = $this->events_model->get_events_by_id($eventId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/events/events');
        endif;        

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->events_model->update_events($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/events/events' . $this->query);
                endif;
            endif;

            redirect('backend/events/events/edit/' . $eventId . $this->query);
        endif;
        
        $data = array(
            'eventId' => $eventId,
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($eventId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->events_model->get_events_by_id($eventId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->events_model->delete_events($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/events/events' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('eventOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_events', $order, 'eventId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/events/events' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/events/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}