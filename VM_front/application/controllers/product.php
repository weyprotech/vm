<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product/tb_category_model','tb_category_model');
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('designer/tb_designer_model','tb_designer_model');
        $this->load->model('designer/tb_designer_banner_model','tb_designer_banner_model');
        $this->load->model('designer/tb_post_model','tb_post_model');        
        $this->load->model('brand/tb_brand_model','tb_brand_model');
    }

    public function index()
    {
        $baseId = $this->input->get('baseId',true);
        $subId = $this->input->get('subId',true);
        $categoryId = $this->input->get('categoryId',true);
        if(!empty($categoryId)){
            $category = $this->tb_category_model->get_category_by_id($categoryId,$this->langId);
            $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.cId','value' => $categoryId)),array(array('field' => 'product.order','dir' => 'desc')),array('start' => 0,'limit' => 20),$this->langId);
            $product_count = $this->tb_product_model->count_product(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.cId','value' => $categoryId)),$this->langId);
        }else if(!empty($subId)){
            $temp = $this->tb_category_model->get_category_select(array(array('field' => 'category.prevId','value' => $subId)),array(array('field' => 'category.order','dir' => 'RANDOM')),array('start' => 0,'limit' => 1),$this->langId);
            $category = $temp[0];
            $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.subId','value' => $subId)),array(array('field' => 'product.order','dir' => 'desc')),array('start' => 0,'limit' => 20),$this->langId);
            $product_count = $this->tb_product_model->count_product(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.subId','value' => $subId)),$this->langId);
        }else{
            $sub_temp = $this->tb_category_model->get_category_select(array(array('field' => 'category.prevId','value' => $baseId)),array(array('field' => 'category.order','dir' => 'RANDOM')),array('start' => 0,'limit' => 1),$this->langId);
            $temp = $this->tb_category_model->get_category_select(array(array('field' => 'category.prevId','value' => $sub_temp[0]->categoryUd)),array(array('field' => 'category.order','dir' => 'RANDOM'),array('start' => 0,'limit' => 1)),$this->langId);
            $category = $temp[0];
            $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.baseId','value' => $baseId)),array(array('field' => 'product.order','dir' => 'desc')),array('start' => 0,'limit' => 20),$this->langId);
            $product_count = $this->tb_product_model->count_product(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.subId','value' => $subId)),$this->langId);
        }

        $data = array(
            'productList' => $productList,
            'category' => $category,
            'product_count' => $product_count
        );

        $this->get_view('product/index', $data);
    }

    public function home(){
        $designerId = $this->input->get('designerId',true);
        if($designerId == ''){
            redirect('designers/index');
        }
        $row = $this->tb_designer_model->get_designer_by_id($designerId,$this->langId);
        if($runway = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.designerId','value' => $designerId)),false,false,$this->langId)){
            $runway_imgList = $this->tb_runway_model->get_runway_img_select(array(array('field' => 'runway_img.runwayId','value' => $runway[0]->runwayId)),array(array('field' => 'runway_img.order','dir' => 'desc')),false);        
        }else{
            $runway_imgList = array();
        }
        $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.designerId','value' => $designerId)),array(array('field' => 'brand.order','dir' => 'desc')),false,$this->langId);
        $designer_bannerList = $this->tb_designer_banner_model->get_designer_banner_select(array(array('field' => 'banner.designerId','value' => $designerId),'other' => array('value' => 'banner.date > \''.date("Y-m-d").'\'')));
        if($postList = $this->tb_post_model->get_post_select(array(array('field' => 'post.designerId','value' => $designerId)),array(array('field' => 'post.order','dir' => 'desc')),false,$this->langId)){
            foreach($postList as $postKey => $postValue){
                $postList[$postKey]->imgList = $this->tb_post_model->get_post_img_select(array(array('field' => 'post_img.postId','value' => $postValue->postId)));
                $postList[$postKey]->message = $this->tb_post_model->get_post_message_select(array(array('field' => 'message.postId','value' => $postValue->postId)));
            }
        }
        $data = array(
            'row' => $row,
            'designer_bannerList' => $designer_bannerList,
            'runway' => $runway[0],
            'runway_imgList' => $runway_imgList,
            'postList' => $postList,
            'brandList' => $brandList
        );
        $this->get_view('designers/home',$data,$this->load->view('shared/script/designers/_home_script','',true));
    }

    public function profile(){
        $designerId = $this->input->get('designerId',true);
        if(!$designerId){
            redirect('designers/index');
        }
        $row = $this->tb_designer_model->get_designer_by_id($designerId,$this->langId);
        $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.designerId','value' => $designerId)),false,false,$this->langId);
        $data = array(
            'row' => $row,
            'brandList' => $brandList            
        );
        $this->get_view('designers/profile',$data,$this->load->view('shared/script/designers/_profile_script','',true));
    }

    public function popup($type,$Id){
        switch($type){
            case 'event':
                $list = $this->tb_runway_model->get_runway_img_select(array(array('field' => 'runway_img.runwayId', 'value' => $Id)),array(array('field' => 'runway_img.order','dir' => 'asc')),false);
                break;
            case 'post':
                $list = $this->tb_post_model->get_post_img_select(array(array('field' => 'post_img.postId', 'value' => $Id)),array(array('field' => 'post_img.order','dir' => 'asc')),false);
                break;
        }
        $data = array(
            'type' => $type,
            'list' => $list
        );
        $this->load->view('content/designers/_popup',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
