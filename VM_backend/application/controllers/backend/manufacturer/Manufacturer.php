<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manufacturer extends Backend_Controller
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

        $this->load->model('manufacturer/tb_manufacturer_model', 'manufacturer_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $manufacturerId = uniqid();
    
        if($post = $this->input->post(null,true)){
            $this->manufacturer_model->insert_manufacturer($post);
            $manufacturerId = $post['manufacturerId'];
            if($this->input->get('back',true)){
                redirect("backend/manufacturer/manufacturer/");
            }
            redirect('backend/manufacturer/manufacturer/edit/' . $manufacturerId . $this->query);
        }
        $this->get_view('add',array('manufacturerId' => $manufacturerId));
    }

    public function edit($manufacturerId = false)
    {
        if (!$row = $this->manufacturer_model->get_manufacturer_by_id($manufacturerId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/manufacturer/manufacturer');
        endif;        

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->manufacturer_model->update_manufacturer($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/manufacturer/manufacturer' . $this->query);
                endif;
            endif;

            redirect('backend/manufacturer/manufacturer/edit/' . $manufacturerId . $this->query);
        endif;
        
        $data = array(
            'manufacturerId' => $manufacturerId,
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($manufacturerId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->manufacturer_model->get_manufacturer_by_id($manufacturerId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->manufacturer_model->delete_manufacturer($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/manufacturer/manufacturer' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('eventOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_manufacturer', $order, 'manufacturerId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/manufacturer/manufacturer' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/manufacturer/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}