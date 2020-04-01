<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('brand/tb_brand_model', 'brand');
    }

    /******************** brand ********************/
    public function get_brand_data()
    {
        header('Content-Type: application/json; charset=utf-8');
        $start = $this->input->get('start',true);
        $brandList = $this->brand->get_brand_select(array(array('field' => 'brand.is_visible','value' => 1)),array(array('field' => 'brand.order','dir' => 'desc')),array('start' => $start,'limit' =>10),$this->langId);
        $data = array(
            'brandList' => $brandList
        );
        echo json_encode($data);
    }


    
    /******************** End brand ********************/
}