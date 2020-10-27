<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tb_member_model', 'tb_member_model');
        $this->load->model('brand/tb_brand_model', 'tb_brand_model');
        $this->load->model('designer/tb_designer_model', 'tb_designer_model');
        $this->load->model('product/tb_category_model', 'tb_category_model');
        $this->load->model('product/tb_product_model', 'tb_product_model');        
        $this->load->model('product/tb_product_like_model', 'tb_product_like_model');        
        $this->load->model('manufacturer/tb_manufacturer_model', 'tb_manufacturer_model');
        $this->load->model('fabric/tb_fabric_model', 'tb_fabric_model');
    }

    public function first_categoryproductlist()
    {
        $apiKey = $this->input->get('apiKey', true);
        $langId = $this->input->get('langId', true);
        if($apiKey != "vmapi")
        {
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得FirstCategoryProduct列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            $categoryList = $this->tb_category_model->get_category_select(array(array('field' => 'category.prevId', 'value' => '0')), array(array('field' => 'category.order','dir' => 'asc')), false, $langId);
            if($categoryList)
            {
                foreach($categoryList as $categoryValue)
                {
                    $sub_category = $this->tb_category_model->get_category_select(array(array('field' => 'category.prevId', 'value' => $categoryValue->categoryId)), array(array('field' => 'category.order','dir' => 'asc')), false, $langId)[0];
                    $last_category = $this->tb_category_model->get_category_select(array(array('field' => 'category.prevId', 'value' => $sub_category->categoryId)), array(array('field' => 'category.order','dir' => 'asc')), false, $langId)[0];
                    $categoryValue->categoryImg = $last_category->categoryImg;
                }
            }

            $response = array(
                'Status' => 'Success',
                'Messages' => $categoryList
            );
            $data = array(
                'model' => 'api串接-取得FirstCategoryProduct列表',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }

        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // 第二層分類
    public function second_categoryproductlist()
    {
        $apiKey = $this->input->get('apiKey');
        $langId = $this->input->get('langId');
        $first_categoryId = $this->input->get('first_categoryId');
        if($apiKey != "vmapi")
        {
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得SecondCategoryProduct列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            $categoryList = $this->tb_category_model->get_category_select(array(array('field' => 'category.prevId', 'value' => $first_categoryId)), array(array('field' => 'category.order','dir' => 'asc')), false, $langId);
            if($categoryList)
            {
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $categoryList
                );
                $data = array(
                    'model' => 'api串接-取得SecondCategoryProduct列表',
                    'log' => '取得成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This CategoryId is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-取得SecondCategoryProduct列表',
                    'log' => '取得失敗，無此類別',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            
        }

        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // 取得產品列表
    public function productlist()
    {
        $apiKey = $this->input->get('apiKey');
        $langId = $this->input->get('langId');
        $second_categoryId = $this->input->get('second_categoryId');
        $memberId = $this->input->get('memberId');
        if($apiKey != "vmapi")
        {
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得Product列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.subId', 'value' => $second_categoryId)), array(array('field' => 'product.order','dir' => 'asc')), false, $langId);
            
            $productLikeList = $this->tb_product_like_model->get_product_like_select();
            if(!empty($memberId))
            {
                // print_r($productList);exit;
                foreach($productList as $productValue)
                {
                    foreach($productLikeList as $productLikeValue)
                    {                        
                        if(($productLikeValue->productId == $productValue->productId) && ($productLikeValue->memberId == $memberId))
                        {
                            $productValue->is_like = true;
                        }
                    }
                }               
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $productList
                );
                $data = array(
                    'model' => 'api串接-取得Product列表',
                    'log' => '取得成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            else
            {
                // print_r($productList);exit;
                $response = array(
                    'Status' => 'Success',
                    'Messages' => empty($productList) ? array() : $productList
                );
                $data = array(
                    'model' => 'api串接-取得Product列表',
                    'log' => '取得成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }            
        }

        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // Get ProductDetail
    public function productdetail()
    {
        $apiKey = $this->input->get('apiKey');
        $langId = $this->input->get('langId');
        $productId = $this->input->get('productId');
        if($apiKey != "vmapi")
        {
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得Product Detail',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            $product = $this->tb_product_model->get_product_by_id($productId, $langId);
            if($product)
            {
                $product_bannerList = $this->tb_product_model->get_product_img_select(array(array('field' => 'product_img.pId' , 'value' => $productId)));
                $product->bannerList = $product_bannerList;

                $brand = $this->tb_brand_model->get_brand_by_id($product->brandId, $langId);
                $product->designer = $this->tb_designer_model->get_designer_by_id($brand->designerId, $langId);

                $product->manufacturer = null;
                if(!empty($product->manufacturerId))
                {                     
                    $manufacturer = $this->tb_manufacturer_model->get_manufacturer_by_id($product->manufacturerId,$langId);
                    if($manufacturer)
                    {
                        $product->manufacturer = $manufacturer;
                    }
                }
                
                $product->fabric = null;
                if(!empty($product->fabricId))
                {
                    $fabric = $this->tb_fabric_model->get_fabric_by_id($product->fabricId,$langId);
                    if($fabric)
                    {
                        $product->fabric = $fabric;
                    }
                }
                
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $product
                );
                $data = array(
                    'model' => 'api串接-取得Product Detail',
                    'log' => '取得成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This ProductId is not Exists'
                );
                $data = array(
                    'model' => 'api串接-取得Product Detail',
                    'log' => '取得失敗，無此產品',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
        }

        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // Product Favorite List
    public function favoritelist()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        $memberId = $this->input->get('memberId', true);
        $page = $this->input->get('page', true);
        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得Product喜歡列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {            
            $member = $this->tb_member_model->get_member_by_id($memberId);
            if($member)
            {
                if(empty($page))
                {
                    $page= 0;
                }
                $favoriteList = $this->tb_product_like_model->get_product_like_select(array(array('field' => 'product_like.memberId', 'value' => $memberId)),false,false,$langId);
                // $favoriteList = $this->tb_product_like_model->get_product_like_select(array(array('field' => 'product_like.memberId', 'value' => $memberId)),false,array('start' => ($page -1) * 10,'limit' =>10),$langId);
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $favoriteList
                );
                $data = array(
                    'model' => 'api串接-取得Product喜歡列表',
                    'log' => '取得成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This MemberId is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-取得Product喜歡列表',
                    'log' => '取得失敗，無此會員',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
        }

        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // POST 加入Favorite
    public function insertfavorite()
    {
        $apiKey = $this->input->get('apiKey');
        $productId = $this->input->get('productId');
        $memberId = $this->input->get('memberId');
        if($apiKey != "vmapi")
        {
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-新增Product Favorite',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            $member = $this->member_model->get_member_by_id($member);
            if($member)
            {
                $like = $this->tb_product_like_model->get_product_like_select(array(array('field' => 'product_like.productId','value' => $productId)));
                if(!$like)
                {
                    $this->tb_product_like_model->insert_product_like(array('memberId' => $memberId,'productId' => $productId));
                    $response = array(
                        'Status' => 'Sucecess',
                        'Messages' => 'Insert Success'
                    );
                    $data = array(
                        'model' => 'api串接-新增Product Favorite',
                        'log' => '新增成功',
                        'create_by' => $this->get_public_ip(),
                        'create_at' => date('Y-m-d H:i:s')
                    );
                }
                else
                {
                    $this->tb_product_like_model->delete_product_like($like[0]);
                    $response = array(
                        'Status' => 'Failed',
                        'Messages' => 'Insert Failed'
                    );
                    $data = array(
                        'model' => 'api串接-刪除Product Favorite',
                        'log' => '刪除成功，已刪除Favorite',
                        'create_by' => $this->get_public_ip(),
                        'create_at' => date('Y-m-d H:i:s')
                    );
                }
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This Member is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-新增Product Favorite',
                    'log' => '取得失敗，無此會員',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
        }
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