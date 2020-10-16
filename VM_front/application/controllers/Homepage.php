<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('designer/tb_designer_model','tb_designer_model');
        $this->load->model('designer/tb_runway_model','tb_runway_model');
        $this->load->model('homepage/tb_homepage_banner_model','tb_homepage_banner_model');
        $this->load->model('homepage/tb_inspiration_model','inspiration_model');
        $this->load->model('brand/tb_brand_model', 'tb_brand_model');
        $this->load->model('brand/tb_brand_banner_model','tb_brand_banner_model');   
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('product/tb_sale_model','tb_sale_model');
        $this->load->model('member/tb_member_inspiration_model','tb_member_inspiration_model');
    }

    public function index()
    {
        //
        $designerList = $this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1)),array(array('field'=>'designer.order','dir' => 'desc')),array('start' => 0,'limit' => 14),$this->langId);
        $homepageBanner = $this->tb_homepage_banner_model->get_homepage_banner_select(array(array('field' => 'banner.is_visible','value' =>1)),array(array('field' => 'banner.order','dir' => 'desc')),false,$this->langId);
        $inspirationList = $this->inspiration_model->get_inspiration_select(array(array('field' => 'inspiration.is_visible','value' => 1)),array(array('field' => 'inspiration.order','dir' => 'desc')),array('start' => 0,'limit' =>15),$this->langId);
        $top_brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.is_visible','value' => 1)),array(array('field'=>'brand.order','dir' => 'desc')),array('start' => 0,'limit' => 5),$this->langId);      
        $top_productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product.is_top','value' => 1)),array(array('field' => 'product.update_at','dir' => 'desc')),array('start' => 0,'limit' => 4),$this->langId);
        foreach($top_brandList as $brandKey => $brandValue){
            $top_brandList[$brandKey]->brandBanner = $this->tb_brand_banner_model->get_brand_banner_select(array(array('field' => 'banner.brandId','value' => $brandValue->brandId)),array(array('field' => 'banner.order','dir' => 'desc')));
        }
        $runwayList = false;
        foreach ($designerList as $designerKey => $designerValue){
            $temp = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.designerId', 'value' => $designerValue->designerId)), array(array('field' => 'runway.runwayId', 'dir' => 'RANDOM')), false, $this->langId);
            if(!empty($temp)){
                $runwayList[$designerKey] = $temp[0];
                $runwayList[$designerKey]->imgList = $this->tb_runway_model->get_runway_img_select(array(array('field' => 'runway_img.runwayId', 'value' => $temp[0]->runwayId)), array(array('field' => 'runway_img.runwayId', 'dir' => 'asc')));
            }
        }
        $saleinformation = $this->tb_sale_model->get_sale_information();
        if($top_productList){
            foreach ($top_productList as $productKey => $productValue){
                if($saleinformation->is_visible == 1){
                    $top_productList[$productKey]->sale = $this->tb_sale_model->get_sale_product_by_pId($productValue->productId);
                }else{
                    $top_productList[$productKey]->sale = false;
                }
            }
        }

        foreach($inspirationList as $inspirationKey => $inspirationValue){
            $inspirationList[$inspirationKey]->like = $this->tb_member_inspiration_model->get_member_inspiration_select(array(array('field' => 'member_inspiration.inspirationId','value' => $inspirationValue->inspirationId),array('field' => 'member_inspiration.memberId','value' => $this->session->userdata('memberinfo')['memberId'])));
        }

        $data = array(
            'designerList' => $designerList,
            'top_brandList' => $top_brandList,
            'top_productList' => $top_productList,
            'saleinformation' => $saleinformation,
            'homepageBanner' => $homepageBanner,
            'inspirationList' => $inspirationList,
            'runwayList' => $runwayList
        );

        $this->get_view('index', $data, $this->load->view('shared/script/_index_script', array('currency' => $this->session->userdata('currency')), true));
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
