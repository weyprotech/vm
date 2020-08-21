<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Backend_Controller
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

        $this->load->model('order/tb_order_model', 'order_model');
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
            $orderId = $this->order_model->insert_order($post);
            if($this->input->get('back',true)){
                redirect("backend/order/order/");
            }
            redirect('backend/order/order/edit/' . $orderId . $this->query);
        }
        $this->get_view('add');
    }

    public function edit($orderId = false)
    {
        if (!$row = $this->order_model->get_order_by_id($orderId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/order/order');
        endif;        

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->order_model->update_order($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/order/order' . $this->query);
                endif;
            endif;

            redirect('backend/order/order/edit/' . $orderId . $this->query);
        endif;
        
        $data = array(
            'orderId' => $orderId,
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($orderId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->order_model->get_order_by_id($orderId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->order_model->delete_order($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/order/order' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('orderOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_order', $order, 'orderId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/order/order' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/order/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}