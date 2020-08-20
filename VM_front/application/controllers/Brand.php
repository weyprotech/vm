<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('brand/tb_brand_model','tb_brand_model');
        $this->load->model('brand/tb_brand_banner_model','tb_brand_banner_model');   
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('designer/tb_designer_model','tb_designer_model');
        $this->load->model('designer/tb_post_model','tb_post_model');
    }

    public function index()
    {
        $top_brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.is_visible','value' => 1)),array(array('field'=>'brand.order','dir' => 'desc')),array('start' => 0,'limit' => 4),$this->langId);      
        $brandList = $this->tb_brand_model->get_brand_select(array(array('field'=>'brand.is_visible','value' => 1)),array(array('field'=>'brand.order','dir' => 'desc')),array('start' => 4,'limit' =>'10'),$this->langId);
        $italyList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.country','value' => 'IT')),array(array('field' => 'brand.order','dir' => 'desc')),array('start' => 0,'limit' => 5),$this->langId);
        
        $data = array(
            'top_brandList' => $top_brandList,
            'brandList' => $brandList,
            'italyList' => $italyList
        );

        $this->get_view('brand/index', $data);
    }

    //A-Z及搜尋頁
    public function search(){
        $alphabet = $this->input->get('alphabet',true);
        $search = $this->input->get('search',true);
        if(!empty($alphabet)){
            $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.is_visible','value' => 1),'other' => array('value' => 'lang.name like "'.$alphabet.'%"')),FALSE,FALSE,$this->langId);
        }elseif(!empty($search)){
            $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.is_visible','value' => 1),'other' => array('value' => 'lang.name like "%'.$search.'%"')),FALSE,FALSE,$this->langId);
        }
        $data = array(
            'brandList' => $brandList,            
            'alphabet' => $alphabet,
            'search' => $search
        );
        $this->get_view('brand/search',$data);
    }

    public function story(){
        $brandId = $this->input->get('brandId',true);
        if($brandId == ''){
            redirect(website_url('brand/index'));
        }
        $row = $this->tb_brand_model->get_brand_by_id($brandId,$this->langId);
        $designer = $this->tb_designer_model->get_designer_by_id($row->designerId,$this->langId);
        $postList = $this->tb_post_model->get_post_select(array(array('field' => 'post.designerId','value' => $row->designerId)),array(array('field' => 'post.order','dir' => 'RANDOM')),array('start' => 0,'limit' =>'3'),$this->langId);
        if($postList){
            foreach($postList as $postKey => $postValue){
                $postList[$postKey]->imglist = $this->tb_post_model->get_post_img_select(array(array('field' => 'post_img.postId','value' => $postValue->postId)),array(array('field' => 'post_img.order','dir' => 'desc')));
            }
        }
        $brandBanner = $this->tb_brand_banner_model->get_brand_banner_select(array(array('field' => 'banner.brandId','value' => $brandId)),array(array('field' => 'banner.order','dir' => 'desc')));
        $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.brandId','value' => $brandId)),array(array('field' => 'banner.order','dir' => 'RANDOM')),array('start' => 0,'limit' => 4),$this->langId);
        // print_r($postList);exit;
        $data = array(
            'row' => $row,
            'designer' => $designer,
            'brandBanner' => $brandBanner,
            'productList' => $productList,
            'postList' => $postList
        );
        $this->get_view('brand/story',$data,$this->load->view('shared/script/designers/_home_script','',true));
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
