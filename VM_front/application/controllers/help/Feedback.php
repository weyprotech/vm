<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('help/tb_feedback_model','feedback_model');
        $this->load->model('help/tb_topic_model','topic_model');
        $this->load->model('company/tb_area_number_model', 'area_number_model');
    }

    public function index()
    {
        $type = $this->input->get('type',true);
        if($post = $this->input->post(null,true)){
            $captcha = $this->input->post('g-recaptcha-response',TRUE);   
            if($captcha && siteverify($captcha)){ 
                $post['is_enable'] = 1;
                unset($post['g-recaptcha-response']);
                $this->feedback_model->insert_feedback($post);
                redirect(website_url('help/feedback/index').'?type=success');
            }else{
                redirect(website_url('help/feedback/index').'?type=error');
            }
        }
        $area_numberList = $this->area_number_model->get_area_number_select(array(array('field' => 'area_number.is_visible','value' => 1)),false,false,$this->langId);
        $topicList = $this->topic_model->get_topic_select(array(array('field' => 'topic.is_visible','value' => 1)),false,false,$this->langId);        
        $data = array(
            'area_numberList' => $area_numberList,
            'topicList' => $topicList,
            'type' => $type
        );
        $this->get_view('help/feedback',$data,$this->load->view('shared/script/help/_feedback_script',$data,true));
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
