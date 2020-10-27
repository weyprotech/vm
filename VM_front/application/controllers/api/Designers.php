<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Designers extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('designer/tb_designer_model','tb_designer_model');
        $this->load->model('designer/tb_designer_banner_model','tb_designer_banner_model');
        $this->load->model('designer/tb_runway_model','tb_runway_model');        
        $this->load->model('designer/tb_post_model','tb_post_model');
        $this->load->model('brand/tb_brand_model','tb_brand_model');
        $this->load->model('member/tb_member_model', 'tb_member_model');
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('product/tb_category_model','tb_category_model');
        $this->load->model('product/tb_sale_model','tb_sale_model');
        $this->load->model('designer/tb_just_model','tb_just_model');
        $this->load->model('designer/tb_message_model','tb_message_model');
        $this->load->model('brand/tb_designer_message_model','tb_designer_message_model');
        $this->load->model('designer/tb_designer_like_model','tb_designer_like_model');
    }    

    public function toplist()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得五位評分最高設計師列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{            
            $designerList = $this->tb_designer_model->get_designer_select(array(array('field'=>'designer.is_visible','value' => 1)),array(array('field'=>'designer.click','dir' => 'desc')),array('start' => 0,'limit' =>'5'),$langId);
            // $designer_story = $this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1),array('field' => 'designer.is_designer_story','value' => 1)),array(array('field' => 'designer.designerId','dir' => 'RANDOM')),false,$this->langId);        
            $response = array(
                'Status' => 'Success',
                'Messages' => $designerList
            );
            $data = array(
                'model' => 'api串接-取得五位評分最高設計師列表',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    public function list(){
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        $page = $this->input->get("page", true);
        $country = $this->input->get('country', true);
        if($page == null){
            $page = 1;
        }

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得設計師列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{            
            $designerList = $this->tb_designer_model->get_designer_select(array(array('field'=>'designer.is_visible','value' => 1), array('field' => 'lang.country', 'value' => $country)),array(array('field'=>'designer.order','dir' => 'desc')),array('start' => ($page -1) * 10,'limit' =>10),$langId);
            // $designer_story = $this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1),array('field' => 'designer.is_designer_story','value' => 1)),array(array('field' => 'designer.designerId','dir' => 'RANDOM')),false,$this->langId);        

            $designerBannerList = $this->tb_designer_banner_model->get_designer_banner_select(false,array(array('field' => 'banner.order','dir' => '1')),false,false);            
            foreach($designerList as $designerValue)
            {
                foreach($designerBannerList as $designerBannerValue)
                {
                    if($designerBannerValue->designerId == $designerValue->designerId)
                    {
                        $designerValue->bannerImg = $designerBannerValue->bannerImg;
                        break;
                    }
                }
            }
            // print_r($designerList);exit;
            $response = array(
                'Status' => 'Success',
                'Messages' => $designerList
            );
            $data = array(
                'model' => 'api串接-取得設計師列表',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }
    
    // Designer Detail
    public function detail()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        $designerId = $this->input->get('designerId', true);
        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得設計師詳細資料',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            $designer = $this->tb_designer_model->get_designer_by_id($designerId,$langId);
            if(!empty($designer))
            {
                $designer->bannerList = $this->tb_designer_banner_model->get_designer_banner_select(array(array('field' => 'banner.designerId', 'value' => $designerId)));
                $designer->brandList = $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.designerId', 'value' => $designerId)),false,false,$langId);
                $postList = $this->tb_post_model->get_post_select(array(array('field' => 'post.designerId', 'value' => $designerId)),false,false,$langId);
                $runwayList = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.designerId', 'value' => $designerId)),false,false,$langId);                
                $post_imgList = $this->tb_post_model->get_post_img_select();
                $runway_imgList = $this->tb_runway_model->get_runway_img_select();
                if($runwayList)
                {
                    foreach($runwayList as $runwayValue)
                    {
                        $runwayValue->runwayImgList = array();
                        $i = 0;
                        foreach($runway_imgList as $runway_imgValue)
                        {
                            if($runway_imgValue->runwayId == $runwayValue->runwayId)
                            {
                                $runwayValue->runwayImgList[$i] = $runway_imgValue;
                                $i++;
                            }
                        }
                    }
                }

                $designer->runwayList = !empty($runwayList) ? $runwayList : array();           
                if($postList)
                {                    
                    foreach($postList as $postValue)
                    {
                        $postValue->postImgList = array();
                        $i = 0;
                        foreach($post_imgList as $post_imgValue)
                        {
                            if($post_imgValue->postId == $postValue->postId)
                            {
                                $postValue->postImgList[$i] = $post_imgValue;
                                $i++;
                            }
                        }
                    }                    
                }
                $designer->postList = !empty($postList) ? $postList : array();
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $designer,
                );
                $data = array(
                    'model' => 'api串接-取得設計師詳細資料',
                    'log' => '取得成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This Designer is not Exist.',
                );
                $data = array(
                    'model' => 'api串接-取得設計師詳細資料',
                    'log' => '取得失敗，無此設計師',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }            
        }        
        print_r(json_encode($response));

        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    //A-Z及搜尋頁
    public function search(){        
        $apiKey = $this->input->post("apiKey", true);
        $langId = $this->input->post("langId", true);
        // $page = $this->input->post('page', true);
        $search = $this->input->post('search',true);

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-設計師搜尋',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{
            $designerList = $this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1),'other' => array('value' => 'lang.name like "%'.$search.'%"')),FALSE,FALSE,$this->langId);
            $response = array(
                'Status' => 'Success',
                'Messages' => $designerList,
            );
            $data = array(
                'model' => 'api串接-設計師搜尋',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // Designer Post List
    public function postlist()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        $postId = $this->input->get('postId', true);
        $designerId = $this->input->get('designerId', true);
        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得設計師Post列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            $post = $this->tb_post_model->get_post_by_id($postId, $langId);            
            if($post)
            {
                $designer = $this->tb_designer_model->get_designer_by_id($designerId,$langId);
                if($designer)
                {
                    $post_imgList = $this->tb_post_model->get_post_img_select(array(array('field' => 'post_img.postId', 'value' => $postId)));
                    $post_messageList = $this->tb_post_model->get_post_message_select(array(array('field' => 'message.postId', 'value' => $postId)),false,false,$langId);
                                    
                    $i = 0;
                    if($post_imgList)
                    {
                        $post->ImgList = array();
                        $i = 0;
                        foreach($post_imgList as $post_imgValue)
                        {
                            if($post_imgValue->postId == $post->postId)
                            {
                                $post->ImgList[$i] = $post_imgValue;
                                $i++;
                            }
                        }
                    }
                    $i = 0;
                    if($post_messageList)
                    {
                        $post->commentList = array();
                        foreach($post_messageList as $post_messageValue)
                        {
                            if($post_messageValue->postId == $post->postId)
                            {
                                $post->commentList[$i] = $post_messageValue;
                                $post->commentList[$i]->designerIcon = $designer->designiconImg;
                                $post->commentList[$i]->designerName = $designer->name;
                                $i++;
                            }
                        }
                    }                    
                    $response = array(
                        'Status' => 'Success',
                        'Messages' => $post
                    );                    
                    $data = array(
                        'model' => 'api串接-取得設計師Post列表',
                        'log' => '取得成功',
                        'create_by' => $this->get_public_ip(),
                        'create_at' => date('Y-m-d H:i:s')
                    );                    
                }
                else
                {
                    $response = array(
                        'Status' => 'Failed',
                        'Messages' => "This DesginerId is not Exist."
                    );
                    $data = array(
                        'model' => 'api串接-取得設計師Post列表',
                        'log' => '新增失敗，無此Designer',
                        'create_by' => $this->get_public_ip(),
                        'create_at' => date('Y-m-d H:i:s')
                    );
                }                                    
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => "This PostId is not Exist."
                );
                $data = array(
                    'model' => 'api串接-取得設計師Post列表',
                    'log' => '新增失敗，無此Post',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
        }
        print_r(json_encode($response));

        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }
    // POST Designer Comments
    public function insertcomments()
    {
        $apiKey = $this->input->post("apiKey", true);
        $postId = $this->input->post("postId", true);
        $memberId = $this->input->post('memberId', true);
        $comments = $this->input->post("comments", true);

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-新增Post Comments',
                'log' => '新增失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{        
            $post = $this->tb_post_model->get_post_by_id($postId,false);
            if($post)
            {
                $member = $this->tb_member_model->get_member_by_id($memberId);                
                if($member)
                {
                    if(!empty($comments))
                    {
                        $post = array();
                        $post['message'] = $comments;
                        $post['memberId'] = $memberId;
                        $post['postId'] = $postId;
                        $this->tb_designer_message_model->insert_designer_message($post);
                        $response = array(
                            'Status' => 'Success',
                            'Messages' => "Insert Success"
                        );
                        $data = array(
                            'model' => 'api串接-新增Post Comments',
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
                            'model' => 'api串接-新增Post Comments',
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
                        'model' => 'api串接-新增Post Comments',
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
                    'Messages' => 'This PostId is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-新增Post Comments',
                    'log' => '取得失敗，無此Designer',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }        
        }        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // Favorite Designer List
    public function favoritelist()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        $page = $this->input->get('page', true);
        $memberId = $this->input->get('memberId', true);

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得設計師喜歡列表',
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
                $favorite_designerList = $this->tb_designer_like_model->get_designer_like_select(array(array('field' => 'designer_like.memberId', 'value' => $memberId)), false,false, $langId);
                // $favorite_designerList = $this->tb_designer_like_model->get_designer_like_select(array(array('field' => 'designer_like.memberId', 'value' => $memberId)), false, array('start' => ($page -1) * 10,'limit' =>10), $langId);
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $favorite_designerList
                );
                $data = array(
                    'model' => 'api串接-取得設計師喜歡列表',
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
                    'model' => 'api串接-取得設計師喜歡列表',
                    'log' => '取得失敗，無此Member',
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
