<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Physical_store extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('company/tb_company_model','company_model');

        $this->load->model('company/tb_physical_store_model','physical_store_model');
    }

    public function index()
    {
        if($this->langFile == 'tw'){
            $this->pageMeta['title'][] = '實體店';
        }else{
            $this->pageMeta['title'][] = 'Physical Stores';
        }
        $company = $this->company_model->get_company_information($this->langId);
        $storeList = $this->physical_store_model->get_physical_store_select(false,array(array('field' => 'physical_store.order', 'dir' => 'desc')),false, $this->langId);
        $data = array(
            'company' => $company,
            'storeList' => $storeList
        );
        $this->get_view('company/about',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
