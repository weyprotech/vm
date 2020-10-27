<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inspiration extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('homepage/tb_inspiration_model','tb_inspiration_model');
        $this->load->model('homepage/tb_inspiration_like_model', 'tb_inspiration_like_model');
        $this->load->model('homepage/tb_inspiration_message_model', 'tb_inspiration_message_model');
        if($this->langFile == 'tw'){
            $this->pageMeta['title'][] = '穿搭';
        }else{
            $this->pageMeta['title'][] = 'OOTD Inspirations';
        }
    }

    public function index()
    {
        $inspirationList = $this->tb_inspiration_model->get_inspiration_select(array(array('field' => 'inspiration.is_visible','value' => 1)),array(array('field'=>'inspiration.order','dir' => 'desc')),array('start' => 0,'limit' => 15),$this->langId);

        $inspiration_like = array();
        $inspiration_likeList = array();
        if($this->session->userdata('memberinfo')){
            $inspiration_likeList = $this->tb_inspiration_like_model->get_inspiration_like_select(array(array('field' => 'inspiration_like.memberId' , 'value' => $this->session->userdata('memberinfo')['memberId'])), false, false);
        }

        $data = array(
            'inspirationList' => $inspirationList,
            'inspiration_likeList' => $inspiration_likeList
        );

        $this->get_view('inspiration/index', $data);
    }

    public function detail(){
        $inspirationId = $this->input->get('inspirationId', true);        
        $row = $this->tb_inspiration_model->get_inspiration_by_id($inspirationId, $this->langId);
        $inspiration_productList = $this->tb_inspiration_model->get_inspiration_related_product_select(array(array('field' => 'relate_product.iId', 'value' => $inspirationId)), false, false, $this->langId);
        if ($post = $this->input->post(null, true)){
            $post['memberId'] = $this->session->userdata('memberinfo')['memberId'];
            $post['inspirationId'] = $inspirationId;
            $this->tb_inspiration_message_model->insert_inspiration_message($post);
        }

        $inspiration_like = array();

        if($this->session->userdata('memberinfo')){
            $inspiration_like = $this->tb_inspiration_like_model->get_inspiration_like_select(array(array('field' => 'inspiration_like.memberId' , 'value' => $this->session->userdata('memberinfo')['memberId']), array('field' => 'inspiration_like.inspirationId', 'value' => $inspirationId)), false, false);
        }

        $inspiration_messageList = $this->tb_inspiration_message_model->get_inspiration_message_select(array(array('field' => 'message.inspirationId', 'value' => $inspirationId)),false,false);
        $inspiration_messageCount = $this->tb_inspiration_message_model->count_inspiration_message(array(array('field' => 'message.inspirationId', 'value' => $inspirationId)));
        // print_r($inspiration_like);exit;
        $data = array(
            'row' => $row,
            'inspirationId' => $inspirationId,
            'inspiration_productList' => $inspiration_productList,
            'inspiration_messageList' => $inspiration_messageList,
            'inspiration_messageCount' => $inspiration_messageCount,
            'inspiration_like' => $inspiration_like
        );
        $this->get_view('inspiration/detail', $data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
