<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sale extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('brand/tb_brand_model','tb_brand_model');
        $this->load->model('brand/tb_brand_banner_model','tb_brand_banner_model');   
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('designer/tb_designer_model','tb_designer_model');
        $this->load->model('designer/tb_post_model','tb_post_model');
        $this->load->model('product/tb_sale_model','tb_sale_model');
        if($this->langFile == 'tw'){
            $this->pageMeta['title'][] = '優惠';
        }else{
            $this->pageMeta['title'][] = 'Sale';
        }
    }

    public function index()
    {
        $page = $this->input->get('page',true) == null ? 1 : $this->input->get('page',true);

        //排序
        if($this->input->get('sort',true) == null){            
            $sort = array(array('field' => 'product.price','dir' => 'asc'));
        }else if($this->input->get('sort',true) == 'price'){
            $sort = array(array('field' => 'product.price','dir' => 'asc'));
        }else if($this->input->get('sort',true) == 'popular'){
            $sort = array(array('field' => 'product.click','dir' => 'desc'));
        }
        $saleinformation = $this->tb_sale_model->get_sale_information($this->langId);
        $saleList = $this->tb_sale_model->get_sale_product_select(array(array('field' => 'product.is_visible','value' => 1)),$sort,array('start' => ($page-1)*20,'limit' => 20),$this->langId);
        $saleCount = $this->tb_sale_model->count_sale_product(array(array('field' => 'product.is_visible','value' => 1)),$this->langId);
        $total_page = ceil($saleCount/20);
        $data = array(
            'saleinformation' => $saleinformation,
            'saleList' => $saleList,
            'saleCount' => $saleCount,
            'sort' => $this->input->get('sort',true) == 'popular' ? 'popular' : 'price',
            'page' => $page,
            'total_page' => $total_page
        );

        $this->get_view('sale/index', $data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
