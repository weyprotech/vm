<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product/tb_category_model','tb_category_model');
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('product/tb_product_review_model','tb_product_review_model');
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
        $page = $this->input->get('page',true) == null ? '1' : $this->input->get('page',true);        

        //排序
        if($this->input->get('sort',true) == null){            
            $sort = array(array('field' => 'product.price','dir' => 'asc'));
        }else if($this->input->get('sort',true) == 'price'){
            $sort = array(array('field' => 'product.price','dir' => 'asc'));
        }else if($this->input->get('sort',true) == 'popular'){
            $sort = array(array('field' => 'product.click','dir' => 'desc'));
        }

        //如果有第三層類別
        if(!empty($categoryId)){
            $category = $this->tb_category_model->get_category_by_id($categoryId,$this->langId);            
            $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.cId','value' => $categoryId)),$sort,array('start' => ($page-1)*20,'limit' => 20),$this->langId);
            $product_count = $this->tb_product_model->count_product(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.cId','value' => $categoryId)),$this->langId);
        }else if(!empty($subId)){  //如果有第二層類別
            $temp = $this->tb_category_model->get_category_select(array(array('field' => 'category.prevId','value' => $subId)),array(array('field' => 'category.order','dir' => 'RANDOM')),array('start' => 0,'limit' => 1),$this->langId);
            $category = $temp[0];
            $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.subId','value' => $subId)),$sort,array('start' => ($page-1)*20,'limit' => 20),$this->langId);
            $product_count = $this->tb_product_model->count_product(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.subId','value' => $subId)),$this->langId);
        }else{ //如果只有第一層類別
            $sub_temp = $this->tb_category_model->get_category_select(array(array('field' => 'category.prevId','value' => $baseId)),array(array('field' => 'category.order','dir' => 'RANDOM')),array('start' => 0,'limit' => 1),$this->langId);
            $temp = $this->tb_category_model->get_category_select(array(array('field' => 'category.prevId','value' => $sub_temp[0]->categoryId)),array(array('field' => 'category.order','dir' => 'RANDOM')),array('start' => 0,'limit' => 1),$this->langId);
            $category = $temp[0];
            $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.baseId','value' => $baseId)),$sort,array('start' => ($page-1)*20,'limit' => 20),$this->langId);
            $product_count = $this->tb_product_model->count_product(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.baseId','value' => $baseId)),$this->langId);
        }

        $total_page = ceil($product_count/20);
        $data = array(
            'productList' => $productList,
            'category' => $category,
            'product_count' => $product_count,
            'page' => $page,
            'total_page' => $total_page,
            'baseId' => $baseId,
            'subId' => $subId,
            'categoryId' => $categoryId,
            'sort' => ($this->input->get('sort',true) == null ? '' : $this->input->get('sort',true))
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

    public function detail(){
        $productId = $this->input->get('productId',true);
        $row = $this->tb_product_model->get_product_by_id($productId,$this->langId);
        if(!$productId && !$row){
            redirect('homepage/index');
        }

        $base_category = $this->tb_category_model->get_category_by_id($row->baseId,$this->langId);
        $sub_category = $this->tb_category_model->get_category_by_id($row->subId,$this->langId);
        $category = $this->tb_category_model->get_category_by_id($row->cId,$this->langId);
        $product_banner = $this->tb_product_model->get_product_img_select(array(array('field' => 'product_img.pId','value' => $productId)),array(array('field' => 'product_img.order','dir' => 'desc')));
        $product_color = $this->tb_product_model->get_product_color_select(array(array('field' => 'product_color.is_visible','value' => 1),array('field' => 'product_color.pId','value' => $productId)),false,false,$this->langId);
        $product_size = $this->tb_product_model->get_product_size_select(array(array('field' => 'product_size.pId','value' => $productId)),array(array('field' => 'product_size.Id','dir' => 'asc')));
        $brand = $this->tb_brand_model->get_brand_by_id($row->brandId,$this->langId);
        $designer = $this->tb_designer_model->get_designer_by_id($brand->designerId);
        $postList = $this->tb_post_model->get_post_select(array(array('field' => 'post.is_visible','value' => 1),array('field' => 'post.designerId','value' => $designer->designerId)));
        $manufacture = $this->tb_product_model->get_product_manufacture_select(array(array('field' => 'product_manufacture.pId','value' => $productId)),false,false,$this->langId);
        $fabric = $this->tb_product_model->get_product_fabric_select(array(array('field' => 'product_fabric.pId','value' => $productId)),false,false,$this->langId);
        $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),'other' => array('value' =>'product.productId != \''.$productId.'\''),array('field' => 'product.subId','value' => $row->subId)),array(array('field' => 'product.Id','dir' => 'RANDOM')),false,false,$this->langId);
        $reviewList = $this->tb_product_review_model->get_product_review_select(array(array('field' => 'review.productId','value' => $productId)));
        
        //最新瀏覽過的產品(cookie存檔)
        $viewed = $this->input->cookie('viewed_product',true);
        $viewedArray = explode('###',$viewed);
        $viewList = array();
        if(!empty($viewArray)){
            foreach($viewedArray as $viewKey => $viewValue){
                $viewList[] = $this->tb_product_model->get_product_by_id($viewValue);
            }
        }
        if(strpos($viewed,$productId) == false){
            $viewed .= '###'.$productId;
            $array = array(
                'name' => 'viewed_product',
                'value' => $viewed,
                'expire' => '86500'
            );
            $this->input->set_cookie($array);
        }


        $data = array(
            'row' => $row,
            'product_banner' => $product_banner,
            'product_color' => $product_color,
            'product_size' => $product_size,
            'brand' => $brand,
            'designer' => $designer,
            'menufacture' => $manufacture,
            'fabric' => $fabric,
            'postList' => $postList,
            'productList' => $productList,
            'base_category' => $base_category,
            'sub_category' => $sub_category,
            'category' => $category,
            'reviewList' => $reviewList
        );
        $this->get_view('product/detail',$data,$this->load->view('shared/script/designers/_profile_script','',true));
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
