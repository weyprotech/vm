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

        $this->load->model('product/tb_category_model', 'category');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true), 'prevId' => $this->input->get('prevId', true),'firstId' => $this->input->get('firstId', true),'secondId' => $this->input->get('secondId', true)));
    }

    public function index()
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index');
    }

    public function add($prevId)
    {
        // $categoryId = $this->category->insert_category($prevId);
        $cId = uniqid();
        if($post = $this->input->post(null,true)){
            if($post['subId'] == 0){
                $post['prevId'] = $post['baseId'];
            }else{
                $post['prevId'] = $post['subId'];
            }
            unset($post['baseId']);
            unset($post['subId']);
            $this->check_action_auth($this->menuId, 'add', true); // Check Auth
            $this->category->insert_category($post);
            $this->set_active_status('success', 'Success');
            if ($this->input->get('back', true)):
                redirect('backend/product/category' . $this->query);
            endif;
            redirect("backend/product/category/edit/" . $post['categoryId'] . "?prevId=" . $prevId);
        }
        $topList = $this->category->get_category_select(array(array('field' => 'category.lv','value' => 1)),false,false,3);
        
        $data = array(
            'cId' => $cId,
            'topList' => $topList
        );
        $this->get_view('add',$data);
    }

    public function edit($categoryId = false)
    {
        if (!$row = $this->category->get_category_by_id($categoryId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/product/category');
        endif;
        $firstList = $this->category->get_category_select(array(array('field' => 'category.lv','value' => 1)),false,false,$this->langId);
        $secondList = $this->category->get_category_select(array(array('field' => 'category.lv','value' => 2)),false,false,$this->langId);
        switch($row->lv){
            case 1:
                $first = '';
                $second = '';
            break;
            case 2:
                $first = $row->prevId;
                $second = '';
            break;
            case 3:
                $prevCategory = $this->category->get_category_by_id($row->prevId,false,array('enable' => false,'visible' => false));
                $first = $prevCategory->prevId;
                $second = $row->prevId;
            break;
        }        

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                if($post['subId'] == 0){
                    $post['prevId'] = $post['baseId'];
                }else{
                    $post['prevId'] = $post['subId'];
                }
                unset($post['baseId']);
                unset($post['subId']);

                $this->category->update_category($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/product/category' . $this->query);
                endif;
            endif;

            redirect('backend/product/category/edit/' . $categoryId . $this->query);
        endif;
        $data = array(
            'row' => $row,
            'first' => $first,
            'second' => $second,
            'firstList' => $firstList,
            'secondList' => $secondList
        );

        $this->get_view('edit', $data);
    }

    public function delete($categoryId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->category->get_category_by_id($categoryId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->category->delete_category($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/product/category' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('categoryOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_product_category', $order, 'categoryId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/product/category' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/product/category/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}