<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Ajax_Controller
{
    public function __construct()
    {        
        parent::__construct();
        $this->load->model('product/tb_product_like_model','tb_product_like_model');
        $this->load->library('my_cart');
    }

    public function set_like(){
        $productId = $this->input->post('productId',true);
        if($this->session->userdata('memberinfo')['memberId']){
            $like = $this->tb_product_like_model->get_product_like_select(array(array('field' => 'product_like.productId','value' => $productId)));
            if(!$like){
                $this->tb_product_like_model->insert_product_like(array('memberId' => $this->session->userdata('memberinfo')['memberId'],'productId' => $productId));
            }else{
                $this->tb_product_like_model->delete_product_like($like[0]);
            }
            echo json_encode(array('status' => 'success'));
        }else{
            echo json_encode(array('status' => 'error'));
        }
    }
}