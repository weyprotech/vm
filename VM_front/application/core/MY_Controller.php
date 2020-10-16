<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $locale;
    public $langId;
    public $langList;
    public $langFile;

    public function __construct()
    {
        parent::__construct();
        $this->langList = $this->website->get_lang_select(false, array(array('field' => 'order', 'dir' => 'asc')));
    }

    public function get_value_from_field($from, $to, $value)
    {
        foreach ($this->langList as $lrow) {
            if ($value == $lrow->$from) return $lrow->$to;
        };

        return $this->langList[0]->$to;
    }
}

/******************** Frontend Class ********************/
class Frontend_Controller extends MY_Controller
{
    protected $pageMeta;
    public $currency;
    public $money_type;
    public $moneyList;
    public function __construct()
    {
        parent::__construct();
        $this->set_lang($this->uri->segment(1));
        $this->pageMeta = array(
            'title' => array('VETRINA MIA'),
            'description' => '',
            'image' => '',
            'url' => current_url()
        );
        
        $this->load->helper('cookie');
        $this->money_type = get_cookie('money_type');
        /***** 取得幣值 ******/
        $this->moneyList = array();
        if($this->money_type != null){ 
            $this->moneyList = $this->money_model->get_money_select(false,false,false);
            switch($this->money_type){
                case 'eur':
                    $this->currency = $this->moneyList[0]->eur_value;
                    break;
                case 'twd':
                    $this->currency = $this->moneyList[0]->twd_value;
                    break;
                default:
                    $this->currency = 1;
            }
            $this->session->set_userdata('currency',$this->currency);
            $this->session->set_userdata('money_type',$this->money_type);
        }
    }

    public function get_frontend_view($page, $data = array(), $script = "", $productId = false, $category = array('menu_basecategory' => '', 'menu_subcategory' => '', 'menu_category' => ''))
    {

        $website_color = $this->website_color->get_set_website_color();
        $data['website_color'] = $website_color;
        /***產品類別 ***/
        //第一層
        $categoryList = $this->product_category_model->get_category_select(array(array('field' => 'category.is_visible', 'value' => 1), array('field' => 'category.lv', 'value' => 1)), array(array('field' => 'category.order', 'dir' => 'asc')), false, $this->langId);        
        //第二層
        foreach($categoryList as $categoryKey => $categoryValue){
            $categoryList[$categoryKey]->categoryList = $this->product_category_model->get_category_select(array(array('field' => 'category.is_visible','value' => 1), array('field' => 'category.prevId', 'value' => $categoryValue->categoryId)), array(array('field' => 'category.order', 'dir' => 'asc')), false, $this->langId);
            //第三層
            if($categoryList[$categoryKey]->categoryList){
                foreach($categoryList[$categoryKey]->categoryList as $base_key => $base_value){
                    $categoryList[$categoryKey]->categoryList[$base_key]->categoryList = $this->product_category_model->get_category_select(array(array('field' => 'category.is_visible', 'value' => 1),array('field' => 'category.prevId', 'value' => $base_value->categoryId)), array(array('field' => 'category.order', 'dir' => 'asc')), false, $this->langId);
                }
            }
        }

        $data['currency'] = $this->currency;

        /***end 產品類別 ***/
        if($productId){
            $product = $this->product_model->get_product_by_id($productId);            
        }else{
            $product = (object)array();
            $product->baseId = '';
            $product->subId = '';
            $product->cId = '';
        }


        //購物車內容
        $this->my_cart->_calc_cart();
        $cart_productList = $this->my_cart->get_product_list();
        $cart_amount = $this->my_cart->amount();
        $cart_total = $this->my_cart->total();  

        /*** 會員資訊 ****/
        if($this->session->userdata('memberinfo')){
            $member = $this->member_model->get_member_by_id($this->session->userdata('memberinfo')['memberId']);
            $data['member'] = $member;
        }   

        return array(
            'pageMeta' => $this->pageMeta,
            'loading' => $this->load->view('shared/_loading', '', true),
            'header_top' => $this->load->view('shared/_header_top', array('website_color' => $website_color,'money_type' => $this->money_type), true),
            'header' => $this->load->view('shared/_header', array('categoryList' => $categoryList,'product' => $product, 'category' => $category,'cart_productList' => $cart_productList,'cart_amount' => $cart_amount,'cart_total' => $cart_total, 'moneyList' => $this->moneyList,'currency' => $this->currency,'money_type' => $this->money_type), true),
            'main' => $this->load->view('content/' . $page, $data, true),
            'footer' => $this->load->view('shared/_footer', array('categoryList' => $categoryList), true),
            'sidebar' => $this->load->view('shared/_sidebar', '', true),
            'script' => $script
        );
    }

    // 設定當前語系
    private function set_lang($lang)
    {
        if ($lang) {
            $this->i18n->set_current_locale($this->get_value_from_field('lang', 'locale', $lang), 300, 'front');
        }
        else {
            $lang = $this->get_value_from_field('locale', 'lang', $this->i18n->get_current_locale('front'));
            // $lang = 'en';
        }
        // print_r($lang);exit;
        $this->i18n->load_language('front');
        $this->locale = $this->i18n->get_current_locale('front');
        $this->langId = $this->get_value_from_field('lang', 'langId', $lang);
        $this->langFile = $lang;
    }
}

/******************** Backend Class ********************/
class Backend_Controller extends MY_Controller
{
    private $lv = array();
    public $prevId = 0;
    public $menuId = 0;
    public $menuList;
    private $action = array('view' => 1, 'edit' => 2, 'add' => 3, 'delete' => 4);

    public function __construct()
    {
        parent::__construct();
        $this->locale = $this->i18n->get_current_locale('backend');
        $this->langId = $this->get_value_from_field('locale', 'langId', $this->locale);
        $this->i18n->set_current_locale($this->locale, 300, 'backend');

        // 取得後台選單
        $this->menuList = $this->get_menu_list();
        if (!empty($this->lv)) {
            $this->menuId = end($this->lv);
            $this->prevId = $this->menuList[$this->menuId]['prevId'];
        }

        // 設定上傳檔案大小
        //ini_set('post_max_size', '10M');
        //ini_set('upload_max_filesize', '10M');

    }

    public function set_active_status($status, $message)
    {
        // 設定動作狀態
        set_cookie('active[status]', $status, 2);
        set_cookie('active[message]', $message, 2);
    }

    public function check_action_auth($menuId, $action = 'view', $back = false)
    {
        if (!$this->session->userdata('is_manager') && $menuId) {
            $auth = $this->session->userdata('auth');

            $boolean = isset($auth[$menuId]) && $auth[$menuId][$this->action[$action]];

            if ($back && !$boolean) {
                js_warn('你未取得權限!');
                redirect('backend/admin');
            }

            return $boolean;
        }

        return true;
    }

    public function get_page_nav($content = false)
    {
        $page_title = "";
        $breadcrumbs = array();
        $menuList = $this->menuList;

        if ($this->menuList) {
            if (!empty($this->lv)) {
                $menu = $menuList[end($this->lv)];
                $page_title = $menu['title'];
                $prevId = $menu['prevId'];

                if ($is_enable = $menu['is_enable']) $menuList[end($this->lv)]['active'] = "active";
                while ($prevId) {
                    if (!$is_enable && $menuList[$prevId]['is_enable']) {
                        $menuList[$prevId]['active'] = 'active';
                    };

                    $breadcrumbs[$prevId] = $menuList[$prevId];
                    $prevId = $menuList[$prevId]['prevId'];
                };
            };
        };

        return array(
            'breadcrumbs' => $breadcrumbs,
            'page_title' => $page_title,
            'menuList' => $menuList,
            'content' => $content
        );
    }

    public function set_http_query($query_data = array())
    {
        $query_data = array_merge($query_data, array('start' => $this->input->get('start', true), 'length' => $this->input->get('length', true)));
        $http_query = http_build_query($query_data);
        return !empty($http_query) ? "?" . $http_query : "";
    }

    // 取得後台選單
    private function get_menu_list()
    {
        $menuList = false;
        if ($menus = $this->menu->menu_get()) {
            foreach ($menus as $mrow) {
                $new_str = str_replace($mrow->menuUrl, '', uri_string(), $active);
                $menuList[$mrow->menuId] = array(
                    'is_enable' => $mrow->is_enable,
                    'title' => $mrow->menuTitle,
                    'icon' => $mrow->menuIcon,
                    'url' => !empty($mrow->menuUrl) ? site_url($mrow->menuUrl) : "javascript:;",
                    'active' => $active ? "active" : false,
                    'prevId' => $mrow->prevId,
                    'is_parent' => false,
                    'is_auth' => $this->check_action_auth($mrow->menuId)
                );

                $menuList[$mrow->prevId]['sub'][] = $mrow->menuId;
                if ($mrow->is_enable) {
                    $menuList[$mrow->prevId]['is_parent'] = true;
                };

                if ($menuList[$mrow->menuId]['active']) {
                    if (isset($this->lv[$mrow->lv])) {
                        $old_str = str_replace($menuList[$this->lv[$mrow->lv]]['url'], '', site_url(uri_string()));
                        if (strlen($new_str) < strlen($old_str)) {
                            $menuList[$this->lv[$mrow->lv]]['active'] = false;
                            $lv[$mrow->lv] = $mrow->menuId;
                        }
                        else {
                            $menuList[$mrow->menuId]['active'] = false;
                        };
                    }
                    else {
                        $this->lv[$mrow->lv] = $mrow->menuId;
                    };
                };
            };
        };
        return $menuList;
    }
}

/******************** Ajax Class ********************/
class Ajax_Controller extends MY_Controller
{
    public $uploadPath = 'assets/uploads/';

    public function __construct()
    {
        parent::__construct();
        $this->locale = $this->i18n->get_current_locale('backend');
        $this->langId = $this->get_value_from_field('locale', 'langId', $this->locale);
        $this->i18n->set_current_locale($this->locale, 300, 'backend');

        if (!is_dir($this->uploadPath)) mkdir($this->uploadPath, 0777);
    }

    public function set_http_query($query_data = array())
    {
        $query_data = array_merge($query_data, array('start' => $this->input->get('start', true), 'length' => $this->input->get('length', true)));
        $http_query = http_build_query($query_data);
        return !empty($http_query) ? "?" . $http_query : "";
    }

    public function get_button($type, $url, $button = '')
    {
        switch ($type) {
            case 'edit':
                $button = '<a href="' . site_url($url) . '" class="btn btn-default"><i class="fa fa-gear"></i><span class="hidden-mobile"> 編輯</span></a>';
                break;
            case 'view':
                $button = '<a href="' . site_url($url) . '" class="btn btn-default"><i class="fa fa-gear"></i><span class="hidden-mobile"> 瀏覽</span></a>';
                break;
            case 'delete':
                $button = '<a href="' . site_url($url) . '" class="btn btn-danger" onclick="return confirm(\'確定要刪除?\');"><i class="glyphicon glyphicon-trash"></i><span class="hidden-mobile"> 刪除</span></a>';
                break;
        }
        return $button;
    }

    public function get_order($type, $objectId, $objectOrder)
    {
        $order = '<input type="hidden" name="' . $type . 'Order[' . $objectId . '][' . $type . 'Id]" value="' . $objectId . '">';
        $order .= '<input type="text" class="form-control text-center" name="' . $type . 'Order[' . $objectId . '][order]" value="' . $objectOrder . '" style="width: 100%;">';
        return $order;
    }

    public function uploadImg($imageData, $dir = '', $width = false)
    {
        $uploadPath = $this->uploadPath;

        if (is_uploaded_file($imageData['tmp_name'])) {
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777);
            if (!is_dir($uploadPath .= $dir)) mkdir($uploadPath, 0777);

            $ext_list = array(1 => "gif", 2 => "jpg", 3 => "png");
            $temp = getimagesize($imageData['tmp_name']);
            $ext = $ext_list[$temp[2]];
            $tempPath = $uploadPath . 'temp.' . $ext;
            $imageName = uniqid('image') . '.' . $ext;
            $thumbName = uniqid('thumb') . '.' . $ext;

            move_uploaded_file($imageData['tmp_name'], $tempPath);
            if (is_numeric($width)) {
                if (in_array($ext, array('png', 'gif'))) {
                    image_resize_transparent($tempPath, $uploadPath . $thumbName, $width, ($width / $temp[0]) * $temp[1]);
                }
                else {
                    $this->image_moo->load($tempPath)->resize($width, ($width / $temp[0]) * $temp[1])->save($uploadPath . $thumbName);
                };
            };
            rename($tempPath, $uploadPath . $imageName);

            return array('name' => $imageData['name'], 'imagePath' => $uploadPath . $imageName, 'thumbPath' => $uploadPath . $thumbName);
        };
    }
}