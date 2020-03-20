<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('product/tb_product_model', 'product_model');
        $this->load->model('product/tb_category_model','category_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $productId = uniqid();
        $size_chart = $this->product_model->get_size_chart();
        $topList = $this->category_model->get_category_select(array(array('field' => 'category.lv','value' => '1')),false,false,$this->langId);    
        if($post = $this->input->post(null,true)){
            $this->set_active_status('success', 'Success');
            unset($post['image_list_length']);
            $productId = $post['productId'];
            $this->product_model->insert_product($post);
            $this->product_model->insert_product_size($post['size'],$post['productId']);
            if ($this->input->get('back', true)):
                redirect('backend/product/product' . $this->query);
            endif;
            redirect("backend/product/product/edit/" . $productId);            
        }
        $data = array(
            'topList' => $topList,
            'productId' => $productId,
            'size_chart' => $size_chart            
        );
        $this->get_view('add',$data);
    }

    public function edit($productId = false)
    {
        if (!$row = $this->product_model->get_product_by_id($productId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/product');
        endif;

        $topList = $this->category_model->get_category_select(array(array('field' => 'category.lv','value' => '1')),false,false,$this->langId); 
        $category = $this->category_model->get_category_by_id($row->cId,$this->langId);
        $sub_category = $this->category_model->get_category_by_id($category->prevId);
        $base_category = $this->category_model->get_category_by_id($sub_category->prevId);
        $subList = $this->category_model->get_category_select(array(array('field' => 'category.prevId','value' => $base_category->categoryId)),false,false,$this->langId);
        $categoryList = $this->category_model->get_category_select(array(array('field' => 'category.prevId','value' => $sub_category->categoryId)),false,false,$this->langId);
        $sizeList = $this->product_model->get_product_size_select(array(array('field' => 'product_size.pId','value' => $productId)),false,false);
        $size_chart = $this->product_model->get_size_chart();
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth
            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->product_model->update_product($row, $post);
                $this->product_model->update_product_size($sizeList,$post['size'],$productId);
                $this->set_active_status('success', 'Success');
                if ($this->input->get('back', true)):
                    redirect('backend/product/product' . $this->query);
                endif;
            endif;

            redirect('backend/product/product/edit/' . $productId . $this->query);
        endif;

        $data = array(
            'productId' => $productId,
            'row' => $row,            
            'size_chart' => $size_chart,
            'sizeList' => $sizeList,
            'topList' => $topList,
            'category' => $category,
            'sub_category' => $sub_category,
            'base_category' => $base_category,
            'subList' => $subList,
            'categoryList' => $categoryList
        );

        $this->get_view('edit', $data);
    }

    public function delete($productId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->product_model->get_product_by_id($productId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->product_model->delete_product($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/product/product' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('productOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_product', $order, 'productId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/product/product' . $this->query);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/product/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}