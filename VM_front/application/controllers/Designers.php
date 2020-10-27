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
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('product/tb_category_model','tb_category_model');
        $this->load->model('product/tb_sale_model','tb_sale_model');
        $this->load->model('designer/tb_just_model','tb_just_model');
        $this->load->model('designer/tb_message_model','tb_message_model');
        $this->load->model('designer/tb_designer_like_model','tb_designer_like_model');
        $this->load->model('designer/tb_wish_model', 'tb_wish_model');
        $this->load->model('member/tb_member_model','member_model');
        $this->load->model('designer/tb_gift_designer_model','tb_gift_designer_model');
        $this->load->library('my_pay_ecpay');
        if($this->langFile == 'tw'){
            $this->pageMeta['title'][] = '設計師';
        }else{
            $this->pageMeta['title'][] = 'Designers';
        }
    }

    public function index()
    {
        $page = $this->input->get('page',true) == null ? '1' : $this->input->get('page',true);        
        $top_designerList = $this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1)),array(array('field'=>'designer.order','dir' => 'desc')),array('start' => 0,'limit' => 4),$this->langId);
        $designerList = $this->tb_designer_model->get_designer_select(array(array('field'=>'designer.is_visible','value' => 1)),array(array('field'=>'designer.order','dir' => 'desc')),array('start' => ($page*10)+4,'limit' =>'10'),$this->langId);        
        $designer_story = $this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1),array('field' => 'designer.is_designer_story','value' => 1)),array(array('field' => 'designer.designerId','dir' => 'RANDOM')),false,$this->langId);
        $count = $this->tb_designer_model->count_designer(array(array('field'=>'designer.is_visible','value' => 1)),$this->langId);
        $total_page = floor(($count-4)/10);
        if(($count-4)%10 == 0){ 
            $total_page-=1;
        }
        //讀取愛心
        if(!$this->session->userdata('memberinfo')){
            foreach ($top_designerList as $designerKey => $designerValue){
                $top_designerList[$designerKey]->like = false;
            }            
        }else{
            foreach ($top_designerList as $designerKey => $designerValue){
                $top_designerList[$designerKey]->like = $this->tb_designer_like_model->get_designer_like_select(array(array('field' => 'designer_like.designerId','value' => $designerValue->designerId),array('field' => 'designer_like.memberId','value' => $this->session->userdata('memberinfo')['memberId'])));
            }
        }
        $data = array(
            'top_designerList' => $top_designerList,
            'designerList' => $designerList,
            'designer_story' => $designer_story,
            'total_page' => $total_page,
            'page' => $page
        );

        $this->get_view('designers/index', $data,$this->load->view('shared/script/designers/_index_script','',true));
    }

    //A-Z及搜尋頁
    public function search(){
        $alphabet = $this->input->get('alphabet',true);
        $search = $this->input->get('search',true);
        if(!empty($alphabet)){
            $designerList = $this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1),'other' => array('value' => 'lang.name like "'.$alphabet.'%"')),FALSE,FALSE,$this->langId);
        }elseif(!empty($search)){
            $designerList = $this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1),'other' => array('value' => 'lang.name like "%'.$search.'%"')),FALSE,FALSE,$this->langId);
        }
        $data = array(
            'designerList' => $designerList,
            'alphabet' => $alphabet,
            'search' => $search
        );
        $this->get_view('designers/search',$data);
    }

    public function home(){
        $designerId = $this->input->get('designerId', true);
        $gift = $this->input->get('gift',true);
        if($designerId == ''){
            redirect(website_url('designers/index'));
        }
        $row = $this->tb_designer_model->get_designer_by_id($designerId, $this->langId);   
        $this->pageMeta['title'][] = $row->name;

        if($runway = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.designerId','value' => $designerId)),false,false,$this->langId)){
            $runway_imgList = $this->tb_runway_model->get_runway_img_select(array(array('field' => 'runway_img.runwayId','value' => $runway[0]->runwayId)),array(array('field' => 'runway_img.order','dir' => 'desc')),false);
        }else{
            $runway_imgList = array();
        }
        $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.designerId','value' => $designerId)), array(array('field' => 'brand.order', 'dir' => 'desc')),false,$this->langId);
        $designer_bannerList = $this->tb_designer_banner_model->get_designer_banner_select(array(array('field' => 'banner.designerId', 'value' => $designerId), array('field' => 'banner.is_visible', 'value' => 1), 'other' => array('value' => '(banner.date = \'\' || banner.date is NULL || banner.date > \''.date("Y-m-d").'\')')), array(array('field' => 'banner.order','dir' => 'desc')));
        if($postList = $this->tb_post_model->get_post_select(array(array('field' => 'post.is_visible', 'value' => 1),array('field' => 'post.designerId','value' => $designerId)),array(array('field' => 'post.order','dir' => 'desc')),false,$this->langId)){
            foreach($postList as $postKey => $postValue){
                $postList[$postKey]->imgList = $this->tb_post_model->get_post_img_select(array(array('field' => 'post_img.postId','value' => $postValue->postId)));
                $postList[$postKey]->message = $this->tb_post_model->get_post_message_select(array(array('field' => 'message.postId','value' => $postValue->postId)));
            }
        }
        //讀取愛心
        $likecount = $this->tb_designer_like_model->count_designer_like(array(array('field' => 'designer_like.designerId','value' => $designerId)));
        if(!$this->session->userdata('memberinfo')){
            $like = false;
        }else{
            $like = $this->tb_designer_like_model->get_designer_like_select(array(array('field' => 'designer_like.designerId','value' => $designerId),array('field' => 'designer_like.memberId','value' => $this->session->userdata('memberinfo')['memberId'])));
        }
        //新增點擊數
        $click = $row->click+1;
        $this->tb_designer_model->update_designer($row,array('click' => $click));

        $data = array(
            'row' => $row,
            'runway' => $runway[0],
            'runway_imgList' => $runway_imgList,
            'postList' => $postList,
            'brandList' => $brandList,
            'link' => $this->load->view('content/designers/_links', array('row' => $row, 'designer_bannerList' => $designer_bannerList, 'brandList' => $brandList, 'like' => $like, 'likecount' => $likecount), true)
        );
        $this->get_view('designers/home',$data,$this->load->view('shared/script/designers/_home_script',array('gift' => $gift),true));
    }

    public function profile(){
        $designerId = $this->input->get('designerId',true);
        if(!$designerId){
            redirect(website_url('designers/index'));
        }
        
        $row = $this->tb_designer_model->get_designer_by_id($designerId,$this->langId);
        $this->pageMeta['title'][] = $row->name;

        $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.designerId','value' => $designerId)),false,false,$this->langId);

        //讀取愛心
        $likecount = $this->tb_designer_like_model->count_designer_like(array(array('field' => 'designer_like.designerId','value' => $designerId)));
        if(!$this->session->userdata('memberinfo')){
            $like = false;
        }else{
            $like = $this->tb_designer_like_model->get_designer_like_select(array(array('field' => 'designer_like.designerId','value' => $designerId),array('field' => 'designer_like.memberId','value' => $this->session->userdata('memberinfo')['memberId'])));
        }

        $data = array(
            'row' => $row,
            'brandList' => $brandList,
            'like' => $like,
            'likecount' => $likecount
        );
        $this->get_view('designers/profile',$data,$this->load->view('shared/script/designers/_profile_script','',true));
    }

    public function product(){
        $designerId = $this->input->get('designerId',true);
        $row = $this->tb_designer_model->get_designer_by_id($designerId,$this->langId);
        $designer_bannerList = $this->tb_designer_banner_model->get_designer_banner_select(array(array('field' => 'banner.designerId', 'value' => $designerId), array('field' => 'banner.is_visible', 'value' => 1), 'other' => array('value' => '(banner.date = \'\' || banner.date is NULL || banner.date > \''.date("Y-m-d").'\')')), array(array('field' => 'banner.order', 'dir' => 'desc')));
        $this->pageMeta['title'][] = $row->name;

        if($designerId == ''){
            redirect(website_url('designers/index'));
        }
        $brandList = $this->tb_brand_model->get_brand_select(array(array('field' => 'brand.designerId','value' => $designerId)),array(array('field' => 'brand.order','dir' => 'desc')),false,$this->langId);        
        //打折%數
        $saleinformation = $this->tb_sale_model->get_sale_information();

        if($brandList){
            $brandId = $this->input->get('brandId',true) == '' ? $brandList[0]->brandId : $this->input->get('brandId');

            $productTemp = $this->tb_product_model->get_product_select(array(array('field' => 'product.brandId','value' => $brandId)),array(array('field' => 'product.order','dir' => 'desc')),false,$this->langId);
            $categoryArray = array();
            if($productTemp){
                foreach($productTemp as $productKey => $productValue){
                    if(!in_array($productValue->cId,$categoryArray)){
                        $categoryArray[] = $productValue->cId;
                    }
                }
                $categoryId = $this->input->get('categoryId',true) == '' ? $categoryArray[0] : $this->input->get('categoryId',true);
                $productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.brandId','value' => $brandId),array('field' => 'product.cId','value' => $categoryId)),array(array('field' => 'product.order','dir' => 'desc')),array('start' => 0,'limit' => 15),$this->langId);

                //打折
                if($productList){
                    foreach ($productList as $productKey => $productValue){
                        if($saleinformation->is_visible == 1){
                            $productList[$productKey]->sale = $this->tb_sale_model->get_sale_product_by_pId($productValue->productId);
                        }else{
                            $productList[$productKey]->sale = false;
                        }
                    }
                }

            }else{
                $productList = false;
                $categoryId = '';
            }
            $categoryList = $this->tb_category_model->get_category_select(array(array('field' => 'category.is_visible','value' => 1),array('field' => 'category.lv','value' => 3),array('field' => 'prev.is_enable','value' => 1),array('field' => 'prev.is_visible','value' => 1),array('field' => 'base_category.is_enable','value' => 1),array('field' => 'base_category.is_visible','value' => 1),'whereIn' => array(array('field' => 'category.categoryId',$categoryArray))),array(array('field' => 'category.order','dir' => 'asc')),false,$this->langId);
            $category = $this->tb_category_model->get_category_by_id($categoryId);
    
            $top_productList = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),array(array('field' => 'product.brandId','value' => $brandId))),array(array('field' => 'product.order','dir' => 'desc')),array('start' => 0,'limit' => 5),$this->langId);
        }else{
            $brandId = '';
            $productTemp = false;
            $categoryArray = array();
            $productList = false;
            $category = false;
            $top_productList = false;
            $categoryList = false;
        }

        //讀取愛心
        $likecount = $this->tb_designer_like_model->count_designer_like(array(array('field' => 'designer_like.designerId','value' => $designerId)));
        if(!$this->session->userdata('memberinfo')){
            $like = false;
        }else{
            $like = $this->tb_designer_like_model->get_designer_like_select(array(array('field' => 'designer_like.designerId','value' => $designerId),array('field' => 'designer_like.memberId','value' => $this->session->userdata('memberinfo')['memberId'])));
        }

        $data = array(
            'row' => $row,
            'designerId' => $designerId,
            'brandId' => $brandId,
            'categoryList' => $categoryList,
            'category' => $category,
            'productList' => $productList,  
            'brandList' => $brandList,
            'saleinformation' => $saleinformation,
            'top_productList' => $top_productList,
            'link' => $this->load->view('content/designers/_links',array('row' => $row,'designer_bannerList' => $designer_bannerList,'like' => $like,'likecount' => $likecount),true)
        );
        $this->get_view('designers/product',$data,$this->load->view('shared/script/designers/_product_script','',true));
    }

    //未抓取評論
    public function review(){
        $designerId = $this->input->get('designerId',true);
        $row = $this->tb_designer_model->get_designer_by_id($designerId,$this->langId);
        $designer_bannerList = $this->tb_designer_banner_model->get_designer_banner_select(array(array('field' => 'banner.designerId', 'value' => $designerId), array('field' => 'banner.is_visible', 'value' => 1), 'other' => array('value' => '(banner.date = \'\' || banner.date is NULL || banner.date > \''.date("Y-m-d").'\')')), array(array('field' => 'banner.order', 'dir' => 'desc')));

        $this->pageMeta['title'][] = $row->name;

        //讀取愛心
        $likecount = $this->tb_designer_like_model->count_designer_like(array(array('field' => 'designer_like.designerId','value' => $designerId)));
        if(!$this->session->userdata('memberinfo')){
            $like = false;
        }else{
            $like = $this->tb_designer_like_model->get_designer_like_select(array(array('field' => 'designer_like.designerId','value' => $designerId),array('field' => 'designer_like.memberId','value' => $this->session->userdata('memberinfo')['memberId'])));
        }

        $data = array(
            'row' => $row,
            'link' => $this->load->view('content/designers/_links',array('row' => $row,'designer_bannerList' => $designer_bannerList,'like' => $like,'likecount' => $likecount),true)
        );
        $this->get_view('designers/review',$data,$this->load->view('shared/script/designers/_review_script','',true));
    }

    public function just_popup($designerId){
        $data = array(        
            'designerId' => $designerId
        );
        $this->load->view('content/designers/_just_popup',$data);        
    }

    public function message_popup($designerId){
        $data = array(
            'designerId' => $designerId
        );

        $this->load->view('content/designers/_message_popup',$data);
    }

    public function wish_popup($designerId){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        if($post = $this->input->post(null,true)){
            $this->tb_wish_model->insert_wish(array('designerId' => $post['designerId'],'memberId' => $this->session->userdata('memberinfo')['memberId'],'title' => $post['title'],'content' => $post['content']));
        }
        
        $data = array(
            'designerId' => $designerId
        );
        $this->load->view('content/designers/_wish_popup', $data);
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

    //贈送禮物
    public function popup_gift($designerId){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        if($post = $this->input->post(null, true)){
            $giftId = $this->tb_gift_designer_model->insert_gift_designer(array(
                'is_enable' => 0,
                'designerId' => $designerId,
                'memberId' => $this->session->userdata('memberinfo')['memberId'],
                'date' => date('Y-m-d'),
                'comment' => $post['comment'],
                'money' => $post['money'],
                'payway' => $post['payway']
            ));

            $designer = $this->tb_designer_model->get_designer_by_id($designerId,$this->langId);

            //匯率
            $moneyList = $this->money_model->get_money_select(false,false,false);
            $productList = array();
            $productList[] = array('Name' => 'Gift designer-'.$designer->name, 'Price' => round($post['money'] * $moneyList[0]->twd_value),
            'Currency' => "元", 'Quantity' => 1, 'URL' => "dedwed");

            //串綠界
            $this->my_pay_ecpay->set_paramer(array(
                'redirect' => website_url("designers/popup_gift_response/$giftId"),
                'return' => website_url('receive_gift'),
                'orderId' => $giftId,
                'money' => round($post['money'] * $moneyList[0]->twd_value),
                'productList' => $productList
            ));

            $member = $this->member_model->get_member_by_id($this->session->userdata('memberinfo')['memberId']);
            switch($post['payway']){
                case '0':                    
                    $mac_code = $this->my_pay_ecpay->credit();
                    break;
                case '2': //扣除會員點數
                    if($member->point < $post['money']){
                        js_warn('error');
                        redirect(website_url());
                    }
                    $point = $member->point-$post['money'];
                    $this->member_model->update_member($member,array('point' => $point));
                    redirect(website_url("designer/popup_gift_response/".$giftId));
                    break;                                
            }
        }
        $data = array(
            'designerId' => $designerId
        );
        $this->load->view('content/designers/popup_gift',$data);
    }

    //贈送禮物回傳
    public function popup_gift_response($giftId){
        $gift = $this->tb_gift_designer_model->get_gift_designer_by_id($giftId);
        if($gift->rtn_msg != 'Succeeded' && $gift->rtn_msg != 'SUCCESS'){
            $post = $this->input->post(null,true);
            $response = $this->my_pay_ecpay->receive();
            $this->db->insert('tb_gift_return_status',array('text' => '----信用卡----'.json_encode($response)));

            if($response == 'CheckMacValue verify fail.'){
                redirect(website_url());
            }
            $member = $this->member_model->get_member_by_id($gift->memberId);
            $return_update = array(
                'is_enable' => 1,
                'rtn_code' => $response['RtnCode'],
                'rtn_msg' => $response['RtnMsg'],
                'trade_no' => $response['TradeNo'],
                'payment_type' => $response['PaymentType'],
                'trade_amount' => $response['TradeAmt'],
                'payment_type_charge_fee' => isset($response['PaymentTypeChargeFee']) ? $response['PaymentTypeChargeFee'] : '',
                'v_account' => isset($response['vAccount']) ? $response['vAccount'] : ''
            );

            $this->tb_gift_designer_model->update_gift_designer($gift,$return_update);
            
            //判斷有沒有綠界金流在此筆交易成功時所產生的序號，有的話session重新更新
            $this->session->set_userdata('memberinfo', array(
                'memberId' => $member->memberId,
                'memberEmail' => $member->email,
                'memberPassword' => $member->password,
                'memberImg' => $member->memberImg,
                'memberFirst_name' => $member->first_name,
                'memberLast_name' => $member->last_name
            ));

        }
        redirect(website_url('designers/home').'?designerId='.$gift->designerId.'&gift=1');
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
