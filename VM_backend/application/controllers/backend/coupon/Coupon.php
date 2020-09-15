<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends Backend_Controller
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

        $this->load->model('coupon/tb_coupon_model', 'coupon_model');
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
            $couponId = $this->coupon_model->insert_coupon($post);
            if($this->input->get('back',true)){
                redirect("backend/coupon/coupon/");
            }
            redirect('backend/coupon/coupon/edit/' . $couponId . $this->query);
        }
        $this->get_view('add');
    }

    public function edit($couponId = false)
    {
        if (!$row = $this->coupon_model->get_coupon_by_id($couponId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/coupon/coupon');
        endif;        

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->coupon_model->update_coupon($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/coupon/coupon' . $this->query);
                endif;
            endif;

            redirect('backend/coupon/coupon/edit/' . $couponId . $this->query);
        endif;
        
        $data = array(
            'couponId' => $couponId,
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($couponId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->coupon_model->get_coupon_by_id($couponId,array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->coupon_model->delete_coupon($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/coupon/coupon' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('couponOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_coupon', $order, 'couponId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/coupon/coupon' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/coupon/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}