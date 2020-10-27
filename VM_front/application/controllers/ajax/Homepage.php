<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends Ajax_Controller
{
    public function __construct()
    {        
        parent::__construct();
        $this->load->model('tb_location_model', 'location_model');
        $this->load->model('brand/tb_brand_model', 'brand_model');
        $this->load->model('money/tb_money_model','money_model');
    }

    /******************** homepage ********************/
    public function get_location()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Set-Cookie: cross-site-cookie=name; SameSite=None; Secure');
        $this->load->helper('cookie');
        $lang = get_cookie('front');
        $count = $this->input->get('count',true);
        $notin = $this->input->get('notin',true);

        $streeList = $this->location_model->get_stree_select();
        $brandList = $this->brand_model->get_brand_select(array(array('field' => 'brand.is_visible','value' => 1)),false,false,$this->langId);
        
        $json = array();

        if($streeList){
            foreach($streeList as $streeKey => $streeValue){
                $json[$streeKey]['id'] = 'street'.str_pad($streeKey, 3, '0', STR_PAD_LEFT);
                $json[$streeKey]['streetName'] = $streeValue->stree;
                $json[$streeKey]['streetDescription'] = '';
                $json[$streeKey]['style'] = 'LUXURY';
                $json[$streeKey]['stores'] = array();
                if($brandList){
                    foreach($brandList as $brandKey => $brandValue){
                        $description = explode('<br>', $brandValue->content);
                        if($brandValue->streeId == $streeValue->Id){
                            $i = $brandKey+1;
                            $json[$streeKey]['stores'][] =
                            array(
                                'id' => 'store'.str_pad($i, 3, '0', STR_PAD_LEFT),
                                'brandId' => $brandValue->brandId,
                                'latlng' => array($brandValue->location_x,$brandValue->location_y),
                                'number' => $i,
                                'storeName' => $brandValue->name,
                                'brandLink' => Site_url($lang.'/brand/story').'?brandId='.$brandValue->brandId,
                                'brandImg' => backend_url($brandValue->brandiconImg),
                                'brandPic' => backend_url($brandValue->brandImg),
                                'description' => $description[0],
                                'productsLink' => Site_url($lang.'/brand/story').'?brandId='.$brandValue->brandId,
                                'designerLink' => Site_url($lang.'/designers/home').'?designerId='.$brandValue->designerId,
                                'designerImg' => backend_url($brandValue->designiconImg),
                                'designerName' => $brandValue->designer_name,
                                'diamond' => true,
                                'flag' => base_url('assets/images/flag/'.$brandValue->country.'.png'),
                                'country' => get_all_country($brandValue->country),
                                'storeicon' => isset($brandValue->store_icon) ? $brandValue->store_icon : 'store_icon'
                            );                    
                        }
                    }                    
                }
            }
        }
                   
        echo json_encode($json);
    }
    

    public function set_currency(){
        $money_type = $this->input->post('money_type',true);
        $this->session->set_userdata('money_type',$money_type);
        /***** 取得幣值 ******/
        $moneyList = array();
        if($money_type != null){ 
            $moneyList = $this->money_model->get_money_select(false,false,false);
            switch($money_type){
                case 'eur':
                    $currency = $moneyList[0]->eur_value;
                    break;
                case 'twd':
                    $currency = $moneyList[0]->twd_value;
                    break;
                default:
                    $currency = 1;
            }
            $this->session->set_userdata('currency',$currency);
        }
        echo json_encode(array('status' => 'success'));
    }
    /******************** End homepage ********************/
}