<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('brand/tb_brand_model', 'brand');
        $this->load->model('brand/tb_brand_message_model','tb_brand_message_model');
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

    public function set_brand_message(){
        $post = $this->input->post(null,true);
        $this->tb_brand_message_model->insert_brand_message(array('brandId' => $post['brandid'],'message' => $post['message'],'memberId' => $this->session->userdata('memberinfo')['memberId']));
        $response = 'success';
        echo json_encode(array('response' => $response,'img' => backend_url($this->session->userdata('memberinfo')['memberImg']),'name' => $this->session->userdata('memberinfo')['memberLast_name'].$this->session->userdata('memberinfo')['memberFirst_name'],'create_at' => date('Y-m-d')));
    }
    
    /******************** End brand ********************/
}