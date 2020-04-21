<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class faq extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
        
        $this->load->model('help/tb_faq_model', 'faq_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true),'baseCategory' => $this->input->get('baseCategory',true),'subCategory' => $this->input->get('subCategory',true),'category' => $this->input->get('category',true)));
    }

    public function index()
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $faqId = uniqid();
        
        if($post = $this->input->post(null,true)){
            $this->set_active_status('success', 'Success');
            
            $faqId = $post['faqId'];
            $this->faq_model->insert_faq($post);           
            if ($this->input->get('back', true)):
                redirect('backend/help/faq' . $this->query);
            endif;
            redirect("backend/help/faq/edit" . $faqId);            
        }
        $data = array(
            'faqId' => $faqId
        );
        $this->get_view('add',$data);
    }

    public function edit($faqId = false)
    {
        if (!$row = $this->faq_model->get_faq_by_id($faqId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/help/faq');
        endif;

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth
            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->faq_model->update_faq($row, $post);
                $this->set_active_status('success', 'Success');
                if ($this->input->get('back', true)):
                    redirect('backend/help/faq' . $this->query);
                endif;
            endif;

            redirect('backend/help/faq/edit/' . $faqId . $this->query);
        endif;
        $data = array(        
            'row' => $row, 
            'faqId' => $faqId
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

        redirect('backend/help/faq/' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('faqOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_faq', $order, 'faqId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/help/faq' . $this->query);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/faq/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}