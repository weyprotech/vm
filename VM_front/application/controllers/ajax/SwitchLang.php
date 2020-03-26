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

        if ($lang = $this->input->get('lang', true)) {
            $url = $this->input->get('url', true);
            $old_lang = $this->uri->segment(1);

            $url_arr = explode('/', $url);
            if ($key = array_search($old_lang, $url_arr)) {
                $url_arr[$key] = $lang;
                $new_url = site_url(array_slice($url_arr, $key));
            }
            else {
                $new_url = site_url($lang);
            }

            echo json_encode(array('status' => true, 'url' => $new_url));
            return true;
        }

        echo json_encode(array('status' => false));
        return true;
    }
}
