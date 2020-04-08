<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Color extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('product/tb_product_model', 'product_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index($productId){
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth
        $data = array(
            'productId' => $productId
        );
        $this->get_view('index',$data);
    }

    public function add($productId)
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $colorId = uniqid();

        if($post = $this->input->post(null,true)){
            $this->product_model->insert_product_color($post);
            $this->set_active_status('success', 'Success');
            $colorId = $post['colorId'];
            if ($this->input->get('back', true)):
                redirect('backend/product/color/index/'.$productId . $this->query);
            endif;
            redirect("backend/product/color/edit/" . $colorId);
        }
        $data = array(
            'colorId' => $colorId,
            'productId' => $productId
        );
        $this->get_view('add',$data);
    }

    public function edit($colorId = false)
    {
        if (!$row = $this->product_model->get_product_color_by_id($colorId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/product/product');
        endif;

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->product_model->update_product_color($row, $post);
                $this->set_active_status('success', 'Success');
                if ($this->input->get('back', true)):
                    redirect('backend/product/color/index/'.$row->pId . $this->query);
                endif;
            endif;

            redirect('backend/product/color/edit/' . $colorId . $this->query);
        endif;

        $data = array(
            'colorId' => $colorId,
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($colorId = false,$productId)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->product_model->get_product_color_by_id($colorId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:        
            $this->product_model->delete_product_color($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/product/color/index/'. $productId. $this->query);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/product/color/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}