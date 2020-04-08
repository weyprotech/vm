<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inspiration extends Backend_Controller
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

        $this->load->model('homepage/tb_inspiration_model', 'inspiration_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $inspirationId = uniqid();
    
        if($post = $this->input->post(null,true)){
            $this->inspiration_model->insert_inspiration($post);
            $inspirationId = $post['inspirationId'];
            if($this->input->get('back',true)){
                redirect("backend/homepage/inspiration/");
            }
            redirect('backend/homepage/inspiration/edit/' . $inspirationId . $this->query);
        }
        $this->get_view('add',array('inspirationId' => $inspirationId));
    }

    public function edit($inspirationId = false)
    {
        if (!$row = $this->inspiration_model->get_inspiration_by_id($inspirationId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/inspiration/inspiration');
        endif;

        $relateproductList = $this->inspiration_model->get_inspiration_related_product_select(array(array('field' => 'relate_product.iId','value' => $inspirationId)),false,false,3);
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->inspiration_model->update_inspiration($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/homepage/inspiration' . $this->query);
                endif;
            endif;

            redirect('backend/homepage/inspiration/edit/' . $inspirationId . $this->query);
        endif;
        
        $data = array(
            'inspirationId' => $inspirationId,
            'relateproductList' => $relateproductList,
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($eventId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->inspiration_model->get_inspiration_by_id($eventId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->inspiration_model->delete_inspiration($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/homepage/inspiration' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('inspirationOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;
            $this->db->update_batch('tb_inspiration', $order, 'inspirationId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/homepage/inspiration' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/homepage/inspiration/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}