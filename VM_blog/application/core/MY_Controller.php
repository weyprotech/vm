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
    public function __construct()
    {
        parent::__construct();
        $this->set_lang($this->uri->segment(1));
        $this->pageMeta = array(
            'title' => array('Blog'),
            'description' => '',
            'image' => '',
            'url' => current_url()
        );

    }

    public function get_frontend_view($page, $data = array(), $script = "",$title = '')
    {
        $this->pageMeta['title'] = $title;
        return array(
            'pageMeta' => $this->pageMeta,
            'header' => $this->load->view('shared/_header', '', true),
            'main' => $this->load->view('content/' . $page, $data, true),
            'footer' => $this->load->view('shared/_footer', '', true),
            'script' => $script,
            
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
        }

        $this->i18n->load_language('front');
        $this->locale = $this->i18n->get_current_locale('front');
        $this->langId = $this->get_value_from_field('lang', 'langId', $lang);
        $this->langFile = $lang;
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