<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tb_member_model', 'tb_member_model');
        $this->load->model('member/tb_member_reward_record_model','tb_member_reward_record_model');
    }

    public function detail()
    {
        $apiKey = $this->input->get("apiKey", true);
        $memberId = $this->input->get('memberId', true);

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得Member Detail',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{
            $member = $this->tb_member_model->get_member_by_id($memberId);
            if($member)
            {
                $rewardList = $this->tb_member_reward_record_model->get_member_reward_record_select(array(array('field' => 'member_reward_record.memberId', 'value' => $memberId)));
                if($rewardList)
                {
                    $member->rewardList = $rewardList;
                }
                else
                {
                    $member->rewardList = array();
                }
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $member
                );
                $data = array(
                    'model' => 'api串接-取得Member Detail',
                    'log' => '取得成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This MemberId is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-取得Member Detail',
                    'log' => '取得失敗，無此會員',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            
        }
        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;        
    }

    // Edit Member Data POST
    public function editmemberdata()
    {
        $apiKey = $this->input->post("apiKey", true);
        $memberId = $this->input->post('memberId', true);
        $name = $this->input->post('name', true);
        $address = $this->input->post('address', true);
        $email = $this->input->post('email', true);

        if($apiKey != "vmapi")
        {
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-更新Member Data',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            $member = $this->tb_member_model->get_member_by_id($memberId);
            if($member)
            {
                $post['email'] = empty($email) ? $member->email : $email;
                $post['first_name'] = empty(explode(" ",$name)[0]) ? $member->first_name : explode(" ",$name)[0];
                $post['last_name'] = empty(explode(" ",$name)[1]) ? $member->first_name : explode(" ",$name)[1];
                $post['address'] = empty($address) ? $member->address : $address;
                $this->tb_member_model->update_member($member, $post);

                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'Update Success'
                );
                $data = array(
                    'model' => 'api串接-更新Member Data',
                    'log' => '更新成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This MemberId is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-更新Member Data',
                    'log' => '取得失敗，無此會員',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
        }

        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;   
    }

    public function editmemberpassword()
    {
        $apiKey = $this->input->post("apiKey", true);
        $memberId = $this->input->post('memberId', true);
        $password = $this->input->post('password', true);
        $chkpassword = $this->input->post('chkpassword', true);
        if($apiKey != "vmapi")
        {
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-更新Member密碼',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            if(!empty($password))
            {
                if($password == $chkpassword)
                {   
                    $member = $this->tb_member_model->get_member_by_id($memberId);
                    if($member)
                    {
                        $post['password'] = $password;
                        $this->tb_member_model->update_member($member, $post);
    
                        $response = array(
                            'Status' => 'Failed',
                            'Messages' => 'Update Success'
                        );
                        $data = array(
                            'model' => 'api串接-更新Member Data',
                            'log' => '更新成功',
                            'create_by' => $this->get_public_ip(),
                            'create_at' => date('Y-m-d H:i:s')
                        );
                    }
                    else
                    {
                        $response = array(
                            'Status' => 'Failed',
                            'Messages' => 'This MemberId is not Exist.'
                        );
                        $data = array(
                            'model' => 'api串接-更新Member Data',
                            'log' => '更新失敗，無此會員',
                            'create_by' => $this->get_public_ip(),
                            'create_at' => date('Y-m-d H:i:s')
                        );
                    }
                }
                else
                {
                    $response = array(
                        'Status' => 'Failed',
                        'Messages' => 'Password is inconsistent with the chkpassword.'
                    );
                    $data = array(
                        'model' => 'api串接-更新Member密碼',
                        'log' => '更新失敗，密碼與確認密碼不一致',
                        'create_by' => $this->get_public_ip(),
                        'create_at' => date('Y-m-d H:i:s')
                    );
                }
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'Password is Empty.'
                );
                $data = array(
                    'model' => 'api串接-更新Member Data',
                    'log' => '更新失敗，密碼為空',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
        }

        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;   
    }

    // POST Login
    public function login()
    {
        $apiKey = $this->input->post("apiKey", true);
        $account = $this->input->post('account', true);
        $password = $this->input->post('password', true);

        if($apiKey != "vmapi")
        {
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-登入',
                'log' => '登入失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            if(!empty($account) && !empty($password))
            {
                $member = $this->tb_member_model->get_member_select(array(array('field' => 'member.email', 'value' => $account), array('field' => 'member.password', 'value' => md5($password))));
                if($member)
                {
                    $response = array(
                        'Status' => 'Success',
                        'Messages' => $member
                    );
                    $data = array(
                        'model' => 'api串接-登入',
                        'log' => '登入成功',
                        'create_by' => $this->get_public_ip(),
                        'create_at' => date('Y-m-d H:i:s')
                    );
                }
                else
                {
                    $response = array(
                        'Status' => 'Failed',
                        'Messages' => 'This Member is not Exist.'
                    );
                    $data = array(
                        'model' => 'api串接-登入',
                        'log' => '登入失敗，無此會員',
                        'create_by' => $this->get_public_ip(),
                        'create_at' => date('Y-m-d H:i:s')
                    );
                }
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'Account or Password is not Empty.'
                );
                $data = array(
                    'model' => 'api串接-登入',
                    'log' => '登入失敗，帳號或密碼不得為空',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
        }

        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;   
    }

    // 取得客戶端IP
    private function get_public_ip(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else
        {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        return $ip_address;
    }
}