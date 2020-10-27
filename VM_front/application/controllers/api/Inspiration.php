<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inspiration extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('homepage/tb_inspiration_model','tb_inspiration_model');
        $this->load->model('homepage/tb_inspiration_banner_model', 'tb_inspiration_banner_model');
        $this->load->model('homepage/tb_inspiration_message_model', 'tb_inspiration_message_model');
        $this->load->model('homepage/tb_inspiration_like_model', 'tb_inspiration_like_model');
        $this->load->model('member/tb_member_model', 'tb_member_model');
        $this->load->model('designer/tb_designer_model','tb_designer_model');
        $this->load->model('brand/tb_brand_model', 'tb_brand_model');
        $this->load->model('product/tb_product_model', 'tb_product_model');        
    }

    public function newlist()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得OOTD最新的5則',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{
            $inspirationList = $this->tb_inspiration_model->get_inspiration_select(array(array('field' => 'inspiration.is_visible','value' => 1)),array(array('field'=>'inspiration.order','dir' => 'desc')),array('start' => 0,'limit' => 5),$langId);
            $inspirationBannerList = $this->tb_inspiration_banner_model->get_inspiration_banner_select();
            $inspirationMessageList = $this->tb_inspiration_message_model->get_inspiration_message_select();

            foreach($inspirationList as $inspirationValue)
            {
                $inspirationValue->commentsList = array();
                $i = 0;
                if(!empty($inspirationMessageList))
                {
                    foreach($inspirationMessageList as $inspirationMessageValue)
                    {
                        if($inspirationValue->inspirationId == $inspirationMessageValue->inspirationId)
                        {
                            $inspirationValue->commentsList[$i] = $inspirationMessageValue;
                            $i++;
                        }
                    }
                }
            }

            foreach($inspirationList as $inspirationValue)
            {
                $inspirationValue->bannerList = array();
                $i = 0;
                foreach($inspirationBannerList as $inspirationBannerValue)
                {
                    if($inspirationValue->inspirationId == $inspirationBannerValue->inspirationId)
                    {
                        $inspirationValue->bannerList[$i] = $inspirationBannerValue;
                        $i++;
                    }
                }
            }
            $response = array(
                'Status' => 'Success',
                'Messages' => $inspirationList
            );
            $data = array(
                'model' => 'api串接-取得OOTD最新的5則',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    public function list()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        $page = $this->input->get("page", true);

        if($page == null){
            $page = 1;
        }

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得OOTD列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{
            $inspirationList = $this->tb_inspiration_model->get_inspiration_select(array(array('field' => 'inspiration.is_visible','value' => 1)),array(array('field'=>'inspiration.order','dir' => 'desc')),array('start' => ($page -1)*10,'limit' => 10),$langId);
            $inspirationBannerList = $this->tb_inspiration_banner_model->get_inspiration_banner_select();
            $inspirationMessageList = $this->tb_inspiration_message_model->get_inspiration_message_select();
            $inspiration_productList = $this->tb_inspiration_model->get_inspiration_related_product_select(false, false, false, $langId);
            $designerList = $this->tb_designer_model->get_designer_select(false,false,false,$langId);
            $brandList = $this->tb_brand_model->get_brand_select();
            $productList = $this->tb_product_model->get_product_select();

            foreach($inspiration_productList as $inspiration_productValue)
            {
                foreach($productList as $productValue)
                {
                    if($inspiration_productValue->productId == $productValue->productId)
                    {
                        $inspiration_productValue->brandId = $productValue->brandId;                            
                    }
                }
            }

            foreach($inspiration_productList as $inspiration_productValue)
            {
                foreach($brandList as $brandValue)
                {
                    if($inspiration_productValue->brandId == $brandValue->brandId)
                    {
                        $inspiration_productValue->designerId = $brandValue->designerId;
                    }
                }
            }

            foreach($inspirationList as $inspirationValue)
            {
                $inspirationValue->designerList = array();
                $i = 0;
                foreach($designerList as $designerValue)
                {
                    foreach($inspiration_productList as $inspiration_productValue)
                    {
                        if($inspiration_productValue->designerId == $designerValue->designerId)
                        {
                            $inspirationValue->designerList[$i] = $designerValue;
                            $i++;
                        }
                    }
                }
            }
            
            foreach($inspirationList as $inspirationValue)
            {
                foreach($inspirationValue->designerList as $Value)
                {
                    $Value->productList = array();
                    $i = 0;
                    foreach($inspiration_productList as $inspiration_productValue)
                    {
                        if($Value->designerId == $inspiration_productValue->designerId)
                        {
                            $Value->productList[$i] = $inspiration_productValue;
                        }
                    }
                }                
            }

            foreach($inspirationList as $inspirationValue)
            {
                $inspirationValue->commentsList = array();
                $i = 0;
                if(!empty($inspirationMessageList))
                {
                    foreach($inspirationMessageList as $inspirationMessageValue)
                    {
                        if($inspirationValue->inspirationId == $inspirationMessageValue->inspirationId)
                        {
                            $inspirationValue->commentsList[$i] = $inspirationMessageValue;
                            $i++;
                        }
                    }
                }
            }
            foreach($inspirationList as $inspirationValue)
            {
                $inspirationValue->bannerList = array();
                $i = 0;
                foreach($inspirationBannerList as $inspirationBannerValue)
                {
                    if($inspirationValue->inspirationId == $inspirationBannerValue->inspirationId)
                    {
                        $inspirationValue->bannerList[$i] = $inspirationBannerValue;
                        $i++;
                    }
                }
            }

            // print_r($inspirationList);exit;
            $response = array(
                'Status' => 'Success',
                'Messages' => $inspirationList
            );
            $data = array(
                'model' => 'api串接-取得OOTD列表',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }  
        // print_r($response);exit;      
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // Get 單一 OOTD Item物件，此物件包含List、相關產品List與Comments List
    public function detail()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        $inspirationId = $this->input->get("inspirationId", true);

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得OOTD Detail',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{        
            $inspiration = $this->tb_inspiration_model->get_inspiration_by_id($inspirationId,$langId);
            if($inspiration)
            {
                $inspirationBannerList = $this->tb_inspiration_banner_model->get_inspiration_banner_select(array(array('field' => 'banner.inspirationId', 'value' => $inspirationId)));
                $inspirationMessageList = $this->tb_inspiration_message_model->get_inspiration_message_select(array(array('field' => 'message.inspirationId', 'value' => $inspirationId)));
                $inspiration_productList = $this->tb_inspiration_model->get_inspiration_related_product_select(array(array('field' => 'relate_product.iId', 'value' => $inspirationId)), false, false, $langId);
                $designerList = $this->tb_designer_model->get_designer_select(false,false,false,$langId);
                $brandList = $this->tb_brand_model->get_brand_select();
                $productList = $this->tb_product_model->get_product_select();
                // print_r($designerList);exit;
                $inspiration->commentsList = array();
                $i = 0;
                if(!empty($inspirationMessageList))
                {
                    foreach($inspirationMessageList as $inspirationMessageValue)
                    {
                        if($inspiration->inspirationId == $inspirationMessageValue->inspirationId)
                        {
                            $inspiration->commentsList[$i] = $inspirationMessageValue;
                            $i++;
                        }
                    }
                }
                $inspiration->bannerList = array();
                $i = 0;
                foreach($inspirationBannerList as $inspirationBannerValue)
                {
                    if($inspiration->inspirationId == $inspirationBannerValue->inspirationId)
                    {
                        $inspiration->bannerList[$i] = $inspirationBannerValue;
                        $i++;
                    }
                }

                
                foreach($inspiration_productList as $inspiration_productValue)
                {
                    foreach($productList as $productValue)
                    {
                        if($inspiration_productValue->productId == $productValue->productId)
                        {
                            $inspiration_productValue->brandId = $productValue->brandId;                            
                        }
                    }
                }

                foreach($inspiration_productList as $inspiration_productValue)
                {
                    foreach($brandList as $brandValue)
                    {
                        if($inspiration_productValue->brandId == $brandValue->brandId)
                        {
                            $inspiration_productValue->designerId = $brandValue->designerId;
                        }
                    }
                }
                
                $inspiration->designerList = array();
                $i = 0;
                foreach($designerList as $designerValue)
                {
                    foreach($inspiration_productList as $inspiration_productValue)
                    {
                        if($inspiration_productValue->designerId == $designerValue->designerId)
                        {
                            $inspiration->designerList[$i] = $designerValue;
                            $i++;
                        }
                    }
                }
                
                foreach($inspiration->designerList as $inspirationValue)
                {
                    $inspirationValue->productList = array();
                    $i = 0;
                    foreach($inspiration_productList as $inspiration_productValue)
                    {
                        if($inspirationValue->designerId == $inspiration_productValue->designerId)
                        {
                            $inspirationValue->productList[$i] = $inspiration_productValue;
                        }
                    }
                }
                
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $inspiration
                );
                $data = array(
                    'model' => 'api串接-取得OOTD Detail',
                    'log' => '取得成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This InspirationId is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-取得OOTD Detail',
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

    // OOTD Favorite List
    public function favoriteiist()
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
                'model' => 'api串接-取得OOTD喜歡列表',
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
                    $page = 1;
                
                }
                $favoriteList = $this->tb_inspiration_like_model->get_inspiration_like_select(array(array('field' => 'inspiration_like.memberId', 'value' => $memberId)));
                // $favoriteList = $this->tb_inspiration_like_model->get_inspiration_like_select(array(array('field' => 'inspiration_like.memberId', 'value' => $memberId)),false,array('start' => ($page -1) * 10,'limit' =>10));
                
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $favoriteList
                );
                $data = array(
                    'model' => 'api串接-取得OOTD喜歡列表',
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
                    'model' => 'api串接-取得OOTD喜歡列表',
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

    // POST OOTD Comments
    public function insertcomments()
    {
        $apiKey = $this->input->post("apiKey", true);
        $inspirationId = $this->input->post("inspirationId", true);
        $memberId = $this->input->post('memberId', true);
        $comments = $this->input->post("comments", true);

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-新增OOTD Comments',
                'log' => '新增失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{        
            $inspiration = $this->tb_inspiration_model->get_inspiration_by_id($inspirationId,false);
            if($inspiration)
            {
                $member = $this->tb_member_model->get_member_by_id($memberId);                
                if($member)
                {
                    if(!empty($comments))
                    {
                        $post = array();
                        $post['message'] = $comments;
                        $post['memberId'] = $memberId;
                        $post['inspirationId'] = $inspirationId;
                        $this->tb_inspiration_message_model->insert_inspiration_message($post);
                        $response = array(
                            'Status' => 'Success',
                            'Messages' => "Insert Success"
                        );
                        $data = array(
                            'model' => 'api串接-新增OOTD Comments',
                            'log' => '新增成功',
                            'create_by' => $this->get_public_ip(),
                            'create_at' => date('Y-m-d H:i:s')
                        );
                    }
                    else
                    {
                        $response = array(
                            'Status' => 'Failed',
                            'Messages' => "Insert Error Comment is Empty"
                        );
                        $data = array(
                            'model' => 'api串接-新增OOTD Comments',
                            'log' => '新增失敗，Comments為空值',
                            'create_by' => $this->get_public_ip(),
                            'create_at' => date('Y-m-d H:i:s')
                        );
                    }
                }                
                else
                {
                    $response = array(
                        'Status' => 'Failed',
                        'Messages' => 'This MemberId is not Exist.'
                    );
                    $data = array(
                        'model' => 'api串接-新增OOTD Comments',
                        'log' => '新增失敗，無此會員',
                        'create_by' => $this->get_public_ip(),
                        'create_at' => date('Y-m-d H:i:s')
                    );
                }                
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This InspirationId is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-新增OOTD Comments',
                    'log' => '取得失敗，無此OOTD',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }        
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
