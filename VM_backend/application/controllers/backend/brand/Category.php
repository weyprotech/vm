<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category extends Backend_Controller
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

        $this->load->model('brand/tb_brand_category_model', 'brand_category');
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
            $categoryId = $this->brand_category->insert_category($post);          
            if($this->input->get('back',true)){                
                redirect("backend/brand/category");
            }            
        }
        $this->get_view('add');
    }

    public function edit($categoryId = false)
    {
        if(!$row = $this->brand_category->get_category_by_id($categoryId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/brand/brand');
        endif;

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Data has been changed');
            else:
                $this->brand_category->update_category($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/brand/category' . $this->query);
                endif;
            endif;

            redirect('backend/brand/category/edit/' . $categoryId . $this->query);
        endif;

        $data = array(
            'categoryId' => $categoryId,
            'row' => $row,
        );

        $this->get_view('edit', $data);
    }

    public function delete($categoryId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->brand_category->get_category_by_id($categoryId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->brand_category->delete_category($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/brand/category' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('brandOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_brand', $order, 'brandId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/brand/brand' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/brand/category/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}