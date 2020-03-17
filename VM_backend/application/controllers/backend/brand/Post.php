<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Post extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('brand/tb_post_model', 'post_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index($brandId)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index',array('brandId' => $brandId));
    }

    public function add($brandId)
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $postId = uniqid();

        if($post = $this->input->post(null,true)){
            $post['brandId'] = $brandId;
            $postId = $post['postId'];
            unset($post['dt_basic_length']);

            $this->post_model->insert_post($post);
            if($this->input->get('back',true)){
                redirect("backend/brand/post/index/".$brandId);
            }
            redirect('backend/brand/post/edit/' . $postId . $this->query);
        }
        $this->get_view('add',array('postId' => $postId,'brandId' => $brandId));
    }

    public function edit($postId = false)
    {

        if (!$row = $this->post_model->get_post_by_id($postId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/post');
        endif;

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                unset($post['dt_basic_length']);
                $this->post_model->update_post($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/brand/post/index/'.$row->brandId . $this->query);
                endif;
            endif;

            redirect('backend/brand/post/edit/' . $postId . $this->query);
        endif;

        $data = array(
            'row' => $row,
            'postId' => $postId,
            'brandId' => $row->brandId
        );

        $this->get_view('edit', $data);
    }

    public function delete($postId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->post_model->get_post_by_id($postId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $brandId = $row->brandId;
            $this->post_model->delete_post($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/brand/post/index/'.$brandId . $this->query);
    }

    public function save($brandId)
    {
        if ($order = $this->input->post('postOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_brand_post', $order, 'postId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/brand/post/index/'.$brandId . $this->query);
    }
    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/brand/post/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}