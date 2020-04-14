<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class My_api
{
    private $api_data = array();

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /** set api parameter
     * 
     * @param array $product
     *
     */
    public function set_api_parameter($post,$memberId,$api_url)
    {        
        $this->api_data = array(
            'member_id' => $memberId,
            'member_img' => $post['memberImg']
        );
        $this->api_data['api_url'] = $api_url;
    }    


    /** excute order
     * 
     * @return $orderId
     */
    public function excute(){
        $result = $this->connect($this->api_data);
        if(isset($result)){
            return json_decode($result);
        }
    }


    /**
     * connect server
     * 
     * @param array $post
     */
    private function connect($post) {
        unset($post['api_url']);


        $_post = Array();
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name.'='.urlencode($value);  //解決網頁URL編碼問題
            }
        }
        $send_data = join('&', $_post);
        

        $ch = curl_init($this->api_data['api_url']);        
        $options = array(
            CURLOPT_RETURNTRANSFER => 1,  //將獲取的訊息以文件流的方式返回
            CURLOPT_POST => True,  //以POST方式傳遞
            CURLOPT_HEADER => false,  //顯示Http Header資訊
            CURLOPT_SSL_VERIFYPEER => false,  //信任認為認證
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,  //是否要抓取轉址
            CURLOPT_POSTFIELDS => $send_data, //POST參數
            CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'  //設定AGENT   如curl_setopt($ch, CURLOPT_USERAGENT, "Google Bot");
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);
        // print_r($result);exit;
        return $result;
    }
}