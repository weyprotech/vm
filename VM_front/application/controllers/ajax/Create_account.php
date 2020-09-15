<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Create_account extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tb_member_model','member_model');
    }

    public function index()
    {
        if($post = $this->input->post(null,true)){
            if($member = $this->member_model->get_member_select(array(array('field' => 'member.email','value' => $post['email'])))){
                echo json_encode(array('status' => 'error','message' => 'This email is already registered'));
            }else{
                $post['memberId'] = uniqid();
                $post['is_enable'] = 1;
                $this->member_model->insert_member($post);
                $member = $this->member_model->get_member_by_id($post['memberId']);
                header('Content-Type: application/json; charset=utf-8');
                $title = 'Verification--VETRINA MIA';
                // $content = '+----------------------------------------------+<br />';
                // $content .= '<b>' . $title . '</b> <br /><br />';
                // $content .= '</b>Hello!' . '<br /><br />';            
                // $content .= 'Verification Url:<br /><b>' . website_url('create_account/check_member/'.$member->uuid) . '</b>' . '<br /><br />';
                
                // $content .= '+---------------------------------------------+<br /><br /><br />';

                $content = $title ;
                $content .= " \n";            
                $content .= 'Hello!';
                $content .= " \n";            
                $content .= 'Verification Url:'."\n".site_url('en/create_account/check_member/'.$member->uuid);
                
                // $content .= '+---------------------------------------------+';
                $this->load->library('email');
                $a=$this->email->attach(base_url('assets/images/logo.png'),'','VETRINA MIA');
                $cid=$this->email->attachment_cid(base_url('assets/images/logo.png'));
                // $content .= '<img src="cid:'.$cid.'"><br>';
                // $content .= 'VETRINA MIA';
                
                $this->email->from('azure_9131e480018e796d9d0b46988542082b@azure.com', 'VETRINA MIA');
                $this->email->to($member->email);
                $this->email->subject('Verification Email-VETRINA MIA');
                $this->email->message($content);
                $this->email->send(false);
                echo json_encode(array('status' => 'success'));
            }           
        }
    }

    //判斷email是否重複
    public function check_email(){
        $email = $this->input->post('email',true);
        if($memberList = $this->member_model->get_member_select(array(array('field' => 'member.email','value' => $email)))){
            echo json_encode(array('status' => 'error'));
        }else{
            echo json_encode(array('status' => 'success'));
        }
    }
}
