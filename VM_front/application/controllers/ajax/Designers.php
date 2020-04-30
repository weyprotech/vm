<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Designers extends Ajax_Controller
{
    public function __construct()
    {        
        parent::__construct();
        $this->load->model('designer/tb_just_model','tb_just_model');
        $this->load->model('designer/tb_message_model','tb_message_model');
        $this->load->model('designer/tb_designer_like_model','tb_designer_like_model');
    }

    /******************** just for you ********************/
    public function set_just()
    {
        header('Content-Type: application/json; charset=utf-8');
        $post = $this->input->post(null,true);
        $post['is_enable'] = 1;
        $this->tb_just_model->insert_just($post);
        $response = 'success';

        echo json_encode(array('response' => $response));
    }
    
    /******************** End just for you ********************/

    /******************** Message ****************************/
    public function set_message()
    {
        header('Content-Type: application/json; charset=utf-8');

        $post = $this->input->post(null,true);
        $post['is_enable'] = 1;
        $this->tb_message_model->insert_message($post);
        $response = 'success';
        echo json_encode(array('response' => $response));
    }
    /******************** End Message ************************/

    public function set_like(){
        $designerId = $this->input->post('designerId',true);
        if($this->session->userdata('memberinfo')['memberId']){
            $like = $this->tb_designer_like_model->get_designer_like_select(array(array('field' => 'designer_like.designerId','value' => $designerId)));
            if(!$like){
                $this->tb_designer_like_model->insert_designer_like(array('memberId' => $this->session->userdata('memberinfo')['memberId'],'designerId' => $designerId));
            }else{
                $this->tb_designer_like_model->delete_designer_like($like[0]);
            }
            echo json_encode(array('status' => 'success'));
        }else{
            echo json_encode(array('status' => 'error'));
        }
       
    }
}