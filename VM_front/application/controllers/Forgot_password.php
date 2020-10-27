<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tb_member_model','member_model');
    }

    public function index()
    {
        if($this->langFile == 'tw'){
            $this->pageMeta['title'][] = '忘記密碼';
        }else{
            $this->pageMeta['title'][] = 'Forgot password';
        }

        $type = $this->input->get('type',true);
        if($post = $this->input->post(null,true)){
            if($member = $this->member_model->get_member_select(array(array('field' => 'member.email','value' => $post['email'])))){
                /*產生新密碼*/
                $num = '';
                for ($i = 0; $i < 6; $i++) {
                    $num .= rand(0, 9);
                }
                $this->member_model->update_member($member[0], array('password' => $num));

                header('Content-Type: application/json; charset=utf-8');
                $title = 'Forgot password--VETRINA MIA';
                // $content = '+----------------------------------------------+<br />';
                // $content .= '<b>' . $title . '</b> <br /><br />';
                // $content .= '</b>Hello!' . '<br /><br />';            
                // $content .= 'New password:<br /><b>' . $num . '</b>' . '<br /><br />';
                
                // $content .= '+---------------------------------------------+<br /><br /><br />';

                // $content = "+----------------------------------------------+<br />";
                $content .= $title."\n";
                $content .= 'New password:' . $num;
                $this->load->library('email');
                $a=$this->email->attach(base_url('assets/images/logo.png'),'','VETRINA MIA');
                $cid=$this->email->attachment_cid(base_url('assets/images/logo.png'));
                // $content .= '<img src="cid:'.$cid.'"><br>';
                // $content .= 'VETRINA MIA';
                
                $this->email->from('azure_9131e480018e796d9d0b46988542082b@azure.com', 'Forgot password--VETRINA MIA');
                $this->email->to($member[0]->email);
                $this->email->subject('Forgot password--VETRINA MIA');
                $this->email->message($content);
                $this->email->send(false);
                redirect(website_url('forgot_password/index').'?type=success');
            }      
        }
        $data = array(
            'type' => $type
        );
        $this->get_view('member/forgot_password',array(),$this->load->view('shared/script/member/_forgot_password_script',$data,true));
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
