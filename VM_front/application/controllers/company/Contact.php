<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('company/tb_contact_model','contact_model');
        $this->load->model('company/tb_area_number_model','area_number_model');
        $this->load->model('company/tb_topic_model', 'topic_model');
    }

    public function index()
    {
        $type = $this->input->get('type',true);
        $area_numberList = $this->area_number_model->get_area_number_select(array(array('field' => 'area_number.is_visible','value' => 1)),false,false,$this->langId);
        $topicList = $this->topic_model->get_topic_select(array(array('field' => 'topic.is_visible','value' => 1)),false,false,$this->langId);

        if($post = $this->input->post(null,true)){
            unset($post['g-recaptcha-response']);
            $captcha = $this->input->post('g-recaptcha-response',TRUE);   
            if($captcha && siteverify($captcha)){ 
                header('Content-Type: application/json; charset=utf-8');
                $title = 'Contact--VETRINA MIA';
                // $content = '+----------------------------------------------+<br />';
                // $content .= '<b>' . $title . '</b> <br /><br />';
                // $content .= '</b>Hello!' . '<br /><br />';            
                // $content .= 'New password:<br /><b>' . $num . '</b>' . '<br /><br />';
                
                // $content .= '+---------------------------------------------+<br /><br /><br />';

                // $content = "+----------------------------------------------+<br />";
                $content = $title."\n";                            
                $content .= 'Name:'.$post['name']."\n";
                $content .= "email:\n";
                $content .= $post['email']."\n";
                $content .= 'phone:'.$post['phone_area_code'].'-'.$post['phone']."\n";
                $content .= 'Contact me:'.($post['contact_type'] == 0 ? 'By Email' : 'By Phone')."\n";
                $content .= 'topic:'.$post['topic']."\n";
                $content .= "comments:".nl2br($post['comments'])."\n";
                
                $this->load->library('email');
                $a=$this->email->attach(base_url('assets/images/logo.png'),'','VETRINA MIA');
                $cid=$this->email->attachment_cid(base_url('assets/images/logo.png'));
                // $content .= '<img src="cid:'.$cid.'"><br>';
                // $content .= 'VETRINA MIA';
                
                $this->email->from('azure_9131e480018e796d9d0b46988542082b@azure.com', 'Contact--VETRINA MIA');
                $this->email->to('talen@weypro.com');
                $this->email->subject('Contact--VETRINA MIA');
                $this->email->message($content);
                $this->email->send(false);

                $post['is_enable'] = 1;
                $this->contact_model->insert_contact($post);
                redirect(website_url('company/contact/index').'?type=success');
            }else{
                redirect(website_url('company/contact/index').'?type=error');
            }
        }
        $data = array(
            'type' => $type,
            'area_numberList' => $area_numberList,
            'topicList' => $topicList
        );
        $this->get_view('company/contact',array(),$this->load->view('shared/script/company/_contact_script',$data,true));
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
