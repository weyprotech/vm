<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SwitchLang extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        header('Content-Type: application/json; charset=utf-8');
        //header('Set-Cookie: cross-site-cookie=name; SameSite=None; Secure');

        if ($lang = $this->input->post('lang', true)) {
            $url = $this->input->post('url', true);
            $new_lang = $this->input->post('new_lang', true);
            //取index.php後的第一個
            $url_arr = explode('/', $url);
            if (in_array($lang, $url_arr)) {
                $new_url = str_replace('/'.$lang,'/'.$new_lang,$url);
            }
            else {
                $new_url = site_url($new_lang);
            }
            
            echo json_encode(array('status' => true, 'url' => $new_url));
            return true;
        }

        echo json_encode(array('status' => false));
        return true;
    }
}
