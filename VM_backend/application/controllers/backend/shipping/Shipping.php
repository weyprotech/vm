<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shipping extends Backend_Controller
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

        $this->load->model('shipping/tb_shipping_model', 'shipping_model');
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
            $shippingId = $this->shipping_model->insert_shipping($post);
            if($this->input->get('back',true)){
                redirect("backend/shipping/shipping/");
            }
            redirect('backend/shipping/shipping/edit/' . $shippingId . $this->query);
        }
        $this->get_view('add');
    }

    public function edit($shippingId = false)
    {
        if (!$row = $this->shipping_model->get_shipping_by_id($shippingId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/shipping/shipping');
        endif;        

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->shipping_model->update_shipping($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/shipping/shipping' . $this->query);
                endif;
            endif;

            redirect('backend/shipping/shipping/edit/' . $shippingId . $this->query);
        endif;
        
        $data = array(
            'shippingId' => $shippingId,
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($shippingId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->shipping_model->get_shipping_by_id($shippingId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->shipping_model->delete_shipping($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/shipping/shipping' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('shippingOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_shipping', $order, 'shippingId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/shipping/shipping' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/shipping/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}