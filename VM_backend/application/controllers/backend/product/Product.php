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
        $topList = $this->category_model->get_category_select(array(array('field' => 'category.lv','value' => '1')),false,false,$this->langId);    
        if($post = $this->input->post(null,true)){
            $productId = $this->product_model->insert_product($post);
            redirect("backend/product/edit/" . $productId);            
        }
        $data = array(
            'topList' => $topList,
            'productId' => $productId
        );
        $this->get_view('add',$data);
    }

    public function edit($productId = false)
    {
        if (!$row = $this->product_model->get_product_by_id($productId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/product');
        endif;

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->product_model->update_product($row, $post);
                $this->set_active_status('success', 'Success');
                if ($this->input->get('back', true)):
                    redirect('backend/product' . $this->query);
                endif;
            endif;

            redirect('backend/product/edit/' . $productId . $this->query);
        endif;

        $data = array(
            'row' => $row,
            'imageList' => $this->product_model->get_product_image_select(
                array(array('field' => 'image.is_visible', 'value' => 1), array('field' => 'image.prevId', 'value' => $productId)), array(array('field' => 'image.order', 'dir' => 'asc')), false
            )
        );

        $this->get_view('edit', $data);
    }

    public function delete($productId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->product_model->get_product_by_id($productId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->product->delete_product($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/product' . $this->query);
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

        redirect('backend/product' . $this->query);
    }

    /******************** Image Function ********************/
    public function image($action, $imageId)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $data = array();
        switch ($action):
            case 'add':
                $this->check_action_auth($this->menuId, 'add', true); // Check Auth

                $productId = $imageId;
                $imageId = $this->product_model->insert_product_image($productId);
                redirect('backend/product/image/edit/' . $imageId . $this->query);
                break;
            case 'edit':
                if (!$row = $this->product_model->get_product_image_by_id($imageId, array('enable' => false, 'visible' => false))):
                    $this->set_active_status('danger', 'The data does not exist!');
                    redirect('backend/product' . $this->query);
                endif;

                if ($post = $this->input->post(null, true)):
                    $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

                    if ($row->uuid != $post['uuid']):
                        $this->set_active_status('danger', 'Date has been changed');
                    else:
                        $this->product_model->update_product_image($row, $post);
                        $this->set_active_status('success', 'Success');

                        if ($this->input->get('back', true)):
                            redirect('backend/product/edit/' . $row->prevId . $this->query . '#3');
                        endif;
                    endif;

                    redirect('backend/product/image/edit/' . $imageId . $this->query);
                endif;

                $data = array(
                    'row' => $row
                );
                break;
            case 'delete':
                $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

                if (!$row = $this->product_model->get_product_image_by_id($imageId, array('enable' => true, 'visible' => false))):
                    $this->set_active_status('danger', 'The data does not exist!');
                else:
                    $this->product_model->delete_product_image($row);
                    $this->set_active_status('success', 'Success');
                    redirect('backend/product/edit/' . $row->prevId . $this->query . '#3');
                endif;

                redirect('backend/product' . $this->query);
                break;
            case 'save':
                if ($order = $this->input->post('imageOrder', true)):
                    $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

                    foreach ($order as $i => $row):
                        $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
                    endforeach;

                    $this->db->update_batch('tb_product_image', $order, 'imageId');
                    $this->set_active_status('success', 'Success');
                endif;

                $productId = $imageId;
                redirect('backend/product/edit/' . $productId . $this->query . '#3');
                break;
        endswitch;

        $this->get_view('image', $data);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/product/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}