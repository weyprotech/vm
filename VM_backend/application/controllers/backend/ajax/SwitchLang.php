<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SwitchLang extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()) {
            redirect("admin");
        }
    }

    public function index()
    {
        if ($locale = $this->input->post('locale', true)) {
            $this->i18n->set_current_locale($locale, 300, 'backend');

            echo json_encode(array('status' => true, 'locale' => $locale));
            return;
        }
        echo json_encode(array('status' => false));
    }
}