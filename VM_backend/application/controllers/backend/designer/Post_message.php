<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Post_message extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('designer/tb_post_model', 'post_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index($postId)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index',array('postId' => $postId));
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
                    redirect('backend/designer/post/index/'.$row->designerId . $this->query);
                endif;
            endif;

            redirect('backend/designer/post/edit/' . $postId . $this->query);
        endif;

        $data = array(
            'row' => $row,
            'postId' => $postId,
            'designerId' => $row->designerId
        );

        $this->get_view('edit', $data);
    }

    public function delete($postId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->post_model->get_post_by_id($postId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $designerId = $row->designerId;
            $this->post_model->delete_post($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/designer/post/index/'.$designerId . $this->query);
    }

    public function save($designerId)
    {
        if ($order = $this->input->post('postOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_designer_post', $order, 'postId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/designer/post/index/'.$designerId . $this->query);
    }
    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/designer/post/message/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}