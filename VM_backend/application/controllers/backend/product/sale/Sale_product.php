<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sale_product extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('product/tb_sale_model', 'sale_model');
        $this->load->model('product/tb_category_model','category_model');    
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index');
    }

    public function delete($Id = false)
    {
        $this->load->model('product/tb_sale_model','sale_model');

        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->sale_model->get_sale_product_by_id($Id, $this->langId)):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->sale_model->delete_sale_product($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/product/sale/sale_product' . $this->query);
    }

   public function get_product(){
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->load->view('backend/product/sale/product/get_product',true);
   }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/product/sale/product/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}