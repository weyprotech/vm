<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Topic extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('company/tb_topic_model', 'topic_model');
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
        $topicId = uniqid();
        if($post = $this->input->post(null,true)){
            $this->topic_model->insert_topic($post);
            $topicId = $post['topicId'];
            if($this->input->get('back',true)){
                redirect("backend/company/topic/index");
            }
            redirect('backend/company/topic/edit/' . $topicId . $this->query);
        }
        $this->get_view('add',array('topicId' => $topicId));
    }

    public function edit($topicId = false)
    {
        if (!$row = $this->topic_model->get_topic_by_id($topicId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/company/topic');
        endif;
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->topic_model->update_topic($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/company/topic' . $this->query);
                endif;
            endif;

            redirect('backend/company/topic/edit/' . $topicId . $this->query);
        endif;

        $data = array(
            'row' => $row,
            'topicId' => $topicId
        );

        $this->get_view('edit', $data);
    }

    public function delete($numberId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->topic_model->get_topic_by_id($numberId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->topic_model->delete_topic($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/company/topic' . $this->query);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/company/contact/topic/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}