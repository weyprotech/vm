<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product/tb_category_model','tb_category_model');
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('product/tb_product_review_model','tb_product_review_model');
        $this->load->model('product/tb_sale_model','tb_sale_model');
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


    public function detail(){
        $productId = $this->input->get('productId',true);
        $reviewpage = ($this->input->get('reviewpage',true) == null ? 1 : $this->input->get('reviewpage',true));
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
        $designer = $this->tb_designer_model->get_designer_by_id($brand->designerId,$this->langId);
        $designer_bannerList = $this->tb_designer_banner_model->get_designer_banner_select(array(array('field' => 'banner.designerId','value' => $brand->designerId),array('field' => 'banner.is_visible','value' => 1),'other' => array('value' => 'banner.date > \''.date("Y-m-d").'\'')),array(array('field' => 'banner.order','dir' => 'desc')),false);
        $postList = $this->tb_post_model->get_post_select(array(array('field' => 'post.is_visible','value' => 1),array('field' => 'post.designerId','value' => $designer->designerId)),array(array('field' => 'post.order','dir' => 'desc')),array('start' => 0,'limit' => 3),$this->langId);
        $manufacture = $this->tb_product_model->get_product_manufacture_select(array(array('field' => 'product_manufacture.pId','value' => $productId)),false,false,$this->langId);
        $fabric = $this->tb_product_model->get_product_fabric_select(array(array('field' => 'product_fabric.pId','value' => $productId)),false,false,$this->langId);
        $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),'other' => array('value' =>'product.productId != \''.$productId.'\''),array('field' => 'product.subId','value' => $row->subId)),array(array('field' => 'product.Id','dir' => 'RANDOM')),false,$this->langId);
        $reviewList = $this->tb_product_review_model->get_product_review_select(array(array('field' => 'review.productId','value' => $productId)));
        $total_review_count = $this->tb_product_review_model->count_product_review(array(array('field' => 'review.productId','value' => $productId)));
        $total_review_page = ceil(($total_review_count/10));
        $saleinformation = $this->tb_sale_model->get_sale_information();
        if($saleinformation->is_visible == 1){
            $sale = $this->tb_sale_model->get_sale_product_by_pId($productId);
        }else{
            $sale = false;
        }
        
        if($postList = $this->tb_post_model->get_post_select(array(array('field' => 'post.is_visible', 'value' => 1),array('field' => 'post.designerId','value' => $brand->designerId)),array(array('field' => 'post.order','dir' => 'desc')),false,$this->langId)){
            foreach($postList as $postKey => $postValue){
                $postList[$postKey]->imgList = $this->tb_post_model->get_post_img_select(array(array('field' => 'post_img.postId','value' => $postValue->postId)));
                $postList[$postKey]->message = $this->tb_post_model->get_post_message_select(array(array('field' => 'message.postId','value' => $postValue->postId)));
            }
        }
        //最新瀏覽過的產品(cookie存檔)
        $viewed = $this->input->cookie('viewed_product',true);
        $viewedArray = explode('###',$viewed);
        $viewList = array();
        if(!empty($viewedArray)){
            foreach($viewedArray as $viewKey => $viewValue){
                if($viewKey != 0){
                    if($temp = $this->tb_product_model->get_product_by_id($viewValue,$this->langId)){
                        $viewList[] = $temp;
                    }
                }
            }
        }

        //紀載此產品至cookie
        if(strpos($viewed,$productId) == false){
            $viewed .= '###'.$productId;
            $array = array(
                'name' => 'viewed_product',
                'value' => $viewed,
                'expire' => '86500'
            );
            $this->input->set_cookie($array);
        }
        
        //記累計產品次數
        $click = $row->click+1;
        $this->product_model->update_product($row,array('click' => $click));

        $data = array(
            'row' => $row,
            'product_banner' => $product_banner,
            'product_color' => $product_color,
            'product_size' => $product_size,
            'brand' => $brand,
            'designer' => $designer,
            'manufacture' => $manufacture[0],
            'fabric' => $fabric[0],
            'postList' => $postList,
            'productList' => $productList,
            'base_category' => $base_category,
            'sub_category' => $sub_category,
            'category' => $category,
            'reviewList' => $reviewList,
            'viewList' => $viewList,
            'saleinformation' => $saleinformation,
            'sale' => $sale,
            'total_review_page' => ($total_review_page == 0) ? '1' : $total_review_page,
            'reviewpage' => $reviewpage,
            'designer_bannerList' => $designer_bannerList
        );
        $this->get_view('product/detail',$data,$this->load->view('shared/script/designers/_profile_script','',true),$productId);
    }

    public function popup_detail($productId){
        $imgList = $this->tb_product_model->get_product_img_select(array(array('field' => 'product_img.pId','value' => $productId)),false,false,$this->langId);
        $data = array(
            'imgList' => $imgList
        );
        $this->load->view('content/product/detail_popup',$data);
    }

    public function popup_manufacture($productId){
        $manufacture = $this->tb_product_model->get_product_manufacture_select(array(array('field' => 'product_manufacture.pId','value' => $productId)),false,false,$this->langId);
        $data = array(
            'manufacture' => $manufacture[0]
        );
        $this->load->view('content/product/manufacture_popup',$data);
    }

    public function popup_fabric($productId){
        $fabric = $this->tb_product_model->get_product_fabric_select(array(array('field' => 'product_fabric.pId','value' => $productId)),false,false,$this->langId);
        $data = array(
            'fabric' => $fabric[0]
        );
        $this->load->view('content/product/fabric_popup',$data);
    }

    private function get_view($page, $data = array(), $script = "",$productId = false)
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script,$productId));
    }
}
