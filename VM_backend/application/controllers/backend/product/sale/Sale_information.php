<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sale_information extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('product/tb_sale_model', 'sale_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function edit()
    {
        $row = $this->sale_model->get_sale_information();
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->sale_model->update_sale_information($post);
                $this->set_active_status('success', 'Success');                
            endif;

            redirect('backend/product/sale/sale_information/edit' . $this->query);
        endif;
        $data = array(            
            'row' => $row
        );

        $this->get_view('edit', $data);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/product/sale/information/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}