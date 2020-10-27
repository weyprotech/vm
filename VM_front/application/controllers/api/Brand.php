<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('brand/tb_brand_model','tb_brand_model');
        $this->load->model('brand/tb_brand_banner_model','tb_brand_banner_model');
        $this->load->model('brand/tb_brand_category_model', 'tb_brand_category_model');
        $this->load->model('designer/tb_designer_model', 'tb_designer_model');
        $this->load->model('designer/tb_designer_banner_model', 'tb_designer_banner_model');
        $this->load->model('product/tb_product_model', 'tb_product_model');
    }

    public function categorybrandlist()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        
        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得CategoryBrand列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{
            $brand_categoryList = $this->tb_brand_category_model->get_category_select(array(array('field' => 'category.is_visible','value' => 1)), false, array('start' => 0,'limit' => 4),$langId);        
            $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.is_visible', 'value' => 1)),false, array('start' => 0,'limit' => 5), $langId);
            $productList = $this->tb_product_model->get_product_select(false,false,false,$langId);
            $designerList = $this->tb_designer_model->get_designer_select(false,false,false,$langId);
            $designer_bannerList = $this->tb_designer_banner_model->get_designer_banner_select(false,false,false,$langId);

            foreach($designerList as $designerValue)
            {
                $designerValue->designer_bannerList = array();
                $i = 0;
                foreach($designer_bannerList as $desnginer_bannerValue)
                {
                    if($designerValue->designerId == $desnginer_bannerValue->designerId)
                    {
                        $designerValue->designer_bannerList[$i] = $desnginer_bannerValue;
                        $i++;
                    }
                }
            }


            foreach($brandList as $brandValue)
            {
                $brandValue->designerList = array();
                $i = 0;
                foreach($designerList as $designerValue)
                {
                    if($brandValue->designerId == $designerValue->designerId)
                    {
                        $brandValue->designerList[$i] = $designerValue;
                        $i++;
                    }
                }
            }

            foreach($brandList as $brandValue)
            {
                $brandValue->productList = array();
                $i = 0;                
                foreach($productList as $productValue)
                {                            
                    if($brandValue->brandId == $productValue->brandId)
                    {                    
                        $brandValue->productList[$i] = $productValue;                    
                        $i++;
                    }
                }
            }

            foreach($brand_categoryList as $brand_categoryValue)
            {
                $i = 0;
                $brand_categoryValue->brandList = array();
                
                foreach($brandList as $brandValue)
                {                            
                    if($brand_categoryValue->categoryId == $brandValue->categoryId)
                    {                  
                        $brand_categoryValue->brandList[$i] = $brandValue;                    
                        $i++;
                    }
                }
            }

            $response = array(
                'Status' => 'Success',
                'Messages' => $brand_categoryList
            );
            $data = array(
                'model' => 'api串接-取得CategoryBrand列表',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // Get 排序前五個 brands List
    public function brandlist(){
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        
        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得Brand列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{            
            $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.is_visible', 'value' => 1)),array(array('field' => 'brand.order','dir' => 'asc')), array('start' => 0,'limit' => 5), $langId);
            $productList = $this->tb_product_model->get_product_select(false,false,false,$langId);
            foreach($brandList as $brandValue)
            {
                $brandValue->productList = array();
                $i = 0;                
                foreach($productList as $productValue)
                {                            
                    if($brandValue->brandId == $productValue->brandId)
                    {                    
                        $brandValue->productList[$i] = $productValue;                    
                        $i++;
                    }
                }
            }

            $response = array(
                'Status' => 'Success',
                'Messages' => $brandList
            );
            $data = array(
                'model' => 'api串接-取得Brand列表',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // GET Brand 物件，此物件包含商品List、設計師物件
    public function brand_detail()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        $brandId = $this->input->get('brandId', true);
        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得單一Brand Detail',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{    
            $brand = $this->tb_brand_model->get_brand_by_id($brandId, $langId);
            if($brand)
            {
                $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.brandId', 'value' => $brandId)),false,false,$langId);
                
                $designerList = $this->tb_designer_model->get_designer_select(false,false,false,$langId);
                $designer_bannerList = $this->tb_designer_banner_model->get_designer_banner_select(false,false,false,$langId);
    
                foreach($designerList as $designerValue)
                {
                    $designerValue->designer_bannerList = array();
                    $i = 0;
                    foreach($designer_bannerList as $desnginer_bannerValue)
                    {
                        if($designerValue->designerId == $desnginer_bannerValue->designerId)
                        {
                            $designerValue->designer_bannerList[$i] = $desnginer_bannerValue;
                            $i++;
                        }
                    }
                }
    
    
                $brand->designerList = array();
                $i = 0;
                foreach($designerList as $designerValue)
                {
                    if($brand->designerId == $designerValue->designerId)
                    {
                        $brand->designerList[$i] = $designerValue;
                        $i++;
                    }
                }

                $brand->productList = array();
                $i = 0;                
                foreach($productList as $productValue)
                {                            
                    if($brand->brandId == $productValue->brandId)
                    {                    
                        $brand->productList[$i] = $productValue;                    
                        $i++;
                    }
                }
                // print_r($brand);exit;
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $brand
                );
                $data = array(
                    'model' => 'api串接-取得單一Brand Detail',
                    'log' => '取得成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This Brand is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-取得單一Brand Detail',
                    'log' => '取得失敗',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
        }
        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // POST Search Brand Name
    public function search_brand(){
        $apiKey = $this->input->post("apiKey", true);
        $langId = $this->input->post("langId", true);
        $search = $this->input->post('search', true);
        if(empty($search))
        {
            $search = "";
        }
        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-搜尋Brand列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{            
            $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.is_visible', 'value' => 1),'other' => array('value' => 'lang.name like "%'.$search.'%"')),array(array('field' => 'brand.order','dir' => 'asc')), array('start' => 0,'limit' => 5), $langId);
            $productList = $this->tb_product_model->get_product_select(false,false,false,$langId);
            foreach($brandList as $brandValue)
            {
                $brandValue->productList = array();
                $i = 0;                
                foreach($productList as $productValue)
                {                            
                    if($brandValue->brandId == $productValue->brandId)
                    {                    
                        $brandValue->productList[$i] = $productValue;                    
                        $i++;
                    }
                }
            }
            
            $response = array(
                'Status' => 'Success',
                'Messages' => $brandList
            );
            $data = array(
                'model' => 'api串接-搜尋Brand列表',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // 取得客戶端IP
    private function get_public_ip(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else
        {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        return $ip_address;
    }
}