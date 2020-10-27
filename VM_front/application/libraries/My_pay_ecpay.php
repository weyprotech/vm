<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class My_pay_ecpay{

    /**
     * 引用ci實作
     * 
     * @var object
     */
    protected $CI;

    /**
     * 服務參數
     */
    protected $obj;
    protected $paramer;

    /**
     * construct
     * 
     */
    public function __construct()
    {
        include('application/sdk/ECPay.Payment.Integration.php');        
    }

    /**
     * set services paramer
     * @var array post
     */
    public function set_paramer($post = array())
    {
        $this->obj = new ECPay_AllInOne();
        
        //服務參數-測試
        $this->obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";  //服務位置
        $this->obj->HashKey     = '5294y06JbISpM5x9' ;                                          //測試用Hashkey，請自行帶入ECPay提供的HashKey
        $this->obj->HashIV      = 'v77hoKGq4kWxNNIS' ;                                          //測試用HashIV，請自行帶入ECPay提供的HashIV
        $this->obj->MerchantID  = '2000132';                                                    //測試用MerchantID，請自行帶入ECPay提供的MerchantID
        $this->obj->EncryptType = '1';                                                   //CheckMacValue加密類型，請固定填入1，使用SHA256加密


        // //服務參數-正式
        // $this->obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";  //服務位置
        // $this->obj->HashKey     = '5294y06JbISpM5x9';                                    //測試用Hashkey，請自行帶入ECPay提供的HashKey
        // $this->obj->HashIV      = 'v77hoKGq4kWxNNIS';                                    //測試用HashIV，請自行帶入ECPay提供的HashIV
        // $this->obj->MerchantID  = '2000132';                                              //測試用MerchantID，請自行帶入ECPay提供的MerchantID
        // $this->obj->EncryptType = '1';                                                   //CheckMacValue加密類型，請固定填入1，使用SHA256加密

        if(!empty($post)){
            $this->paramer = array(
                'return' => $post['return'],
                'redirect' => $post['redirect'],
                'orderId' => $post['orderId'],
                'money' => $post['money'],
                'productList' => $post['productList']
            );
        }
    }

    /**
     * excute all
     * 
     */
    public function all()
    {
        try {
            //基本參數(請依系統規劃自行調整)
            $this->obj->Send['ReturnURL']         = $this->paramer['return'];     //當消費者付款完成後付款完成通知回傳的網址
            $this->obj->Send['ClientRedirectURL'] = $this->paramer['redirect'];     //訂單建立完成後回傳的網址,atm、超商繳款
            $this->obj->Send['OrderResultURL'] =  $this->paramer['redirect'];    //即時交易Client端回傳付款結果網址
            $this->obj->Send['MerchantTradeNo']   = $this->paramer['orderId'];                           //訂單編號
            $this->obj->Send['NeedExtraPaidInfo'] = 'Y';
            $this->obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                        //交易時間
            $this->obj->Send['TotalAmount']       = $this->paramer['money'];                                      //交易金額
            $this->obj->Send['TradeDesc']         = "VETRINA MIA-Payment" ;                           //交易描述
            $this->obj->Send['IgnorePayment']     = 'BARCODE';            //隱藏付款方式
            $this->obj->Send['ChoosePayment']     = ECPay_PaymentMethod::ALL ;                  //付款方式:全功能
            $this->obj->Send['PaymentType']       = 'aio';

            
    
            //訂單的商品資料
            foreach ($this->paramer['productList'] as $productKey => $productValue){
                array_push($this->obj->Send['Items'], $productValue);
            }

            //產生訂單(auto submit至ECPay)
            $this->obj->CheckOut();

        } catch (Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    /**
     * excute atm
     * 
     */
    public function atm()
    {
        try {
            //基本參數(請依系統規劃自行調整)
            $this->obj->Send['ReturnURL']         = $this->paramer['return'];     //當消費者付款完成後付款完成通知回傳的網址
            $this->obj->Send['MerchantTradeNo']   = $this->paramer['orderId'];                           //訂單編號
            $this->obj->Send['NeedExtraPaidInfo'] = 'Y';
            $this->obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                        //交易時間
            $this->obj->Send['TotalAmount']       = $this->paramer['money'];                                      //交易金額
            $this->obj->Send['TradeDesc']         = "VETRINA MIA-Payment" ;                           //交易描述
            $this->obj->Send['ChoosePayment']     = ECPay_PaymentMethod::ATM ;                  //付款方式:atm
    
            //訂單的商品資料
            foreach ($this->paramer['productList'] as $productKey => $productValue){
                array_push($this->obj->Send['Items'], $productValue);
            }
                       
            $this->obj->SendExtend['ClientRedirectURL'] = $this->paramer['redirect'];     //訂單建立完成後回傳的網址,atm、超商繳款

            //產生訂單(auto submit至ECPay)
            $this->obj->CheckOut();

        } catch (Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    /**
     * excute cvs  超商代碼
     * 
     */
    public function cvs()
    {
        try {
            //基本參數(請依系統規劃自行調整)
            $this->obj->Send['ReturnURL']         = $this->paramer['return'];     //當消費者付款完成後付款完成通知回傳的網址 
            $this->obj->Send['MerchantTradeNo']   = $this->paramer['orderId'];                           //訂單編號
            $this->obj->Send['NeedExtraPaidInfo'] = 'Y';
            $this->obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                        //交易時間
            $this->obj->Send['TotalAmount']       = $this->paramer['money'];                                      //交易金額
            $this->obj->Send['TradeDesc']         = "VETRINA MIA-Payment" ;                           //交易描述
            $this->obj->Send['ChoosePayment']     = ECPay_PaymentMethod::CVS ;                  //付款方式:CVS

            
            //訂單的商品資料
            foreach ($this->paramer['productList'] as $productKey => $productValue){
                array_push($this->obj->Send['Items'], $productValue);
            }

            //CVS超商代碼延伸參數(可依系統需求選擇是否代入)
            $this->obj->SendExtend['ClientRedirectURL'] = $this->paramer['redirect'];     //訂單建立完成後回傳的網址,atm、超商繳款
            // $this->obj->SendExtend['Desc_1']            = '';      //交易描述1 會顯示在超商繳費平台的螢幕上。預設空值
            // $this->obj->SendExtend['Desc_2']            = '';      //交易描述2 會顯示在超商繳費平台的螢幕上。預設空值
            // $this->obj->SendExtend['Desc_3']            = '';      //交易描述3 會顯示在超商繳費平台的螢幕上。預設空值
            // $this->obj->SendExtend['Desc_4']            = '';      //交易描述4 會顯示在超商繳費平台的螢幕上。預設空值
            // $this->obj->SendExtend['PaymentInfoURL']    = '';      //端回傳付款相關資訊，預設空值
            // $this->obj->SendExtend['StoreExpireDate']   = '';      //預設空值
            //產生訂單(auto submit至ECPay)
            $this->obj->CheckOut();

        } catch (Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    /**
     * excute WebATM  網路銀行
     * 
     */
    public function web_atm()
    {
        try {
            //基本參數(請依系統規劃自行調整)
            $this->obj->Send['ReturnURL']         = $this->paramer['return'];     //當消費者付款完成後付款完成通知回傳的網址
            $this->obj->Send['OrderResultURL'] =  $this->paramer['redirect'];    //即時交易Client端回傳付款結果網址
            $this->obj->Send['MerchantTradeNo']   = $this->paramer['orderId'];                           //訂單編號
            $this->obj->Send['NeedExtraPaidInfo'] = 'Y';
            $this->obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                        //交易時間
            $this->obj->Send['TotalAmount']       = $this->paramer['money'];                                      //交易金額
            $this->obj->Send['TradeDesc']         = "VETRINA MIA-Payment" ;                           //交易描述
            $this->obj->Send['ChoosePayment']     = ECPay_PaymentMethod::WebATM ;                  //付款方式:WebATM
    
            //訂單的商品資料
            foreach ($this->paramer['productList'] as $productKey => $productValue){
                array_push($this->obj->Send['Items'], $productValue);
            }

            //產生訂單(auto submit至ECPay)
            $this->obj->CheckOut();

        } catch (Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    /**
     * excute creditCard  信用卡
     * 
     */
    public function credit()
    {
        try {
            //基本參數(請依系統規劃自行調整)
            $this->obj->Send['ReturnURL']         = $this->paramer['return'];     //當消費者付款完成後付款完成通知回傳的網址
            $this->obj->Send['OrderResultURL'] =  $this->paramer['redirect'];    //即時交易Client端回傳付款結果網址
            $this->obj->Send['MerchantTradeNo']   = $this->paramer['orderId'];                           //訂單編號
            $this->obj->Send['NeedExtraPaidInfo'] = 'Y';
            $this->obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                        //交易時間
            $this->obj->Send['TotalAmount']       = $this->paramer['money'];                                      //交易金額
            $this->obj->Send['TradeDesc']         = "VETRINA MIA-Payment" ;                           //交易描述
            $this->obj->Send['ChoosePayment']     = ECPay_PaymentMethod::Credit ;                  //付款方式:Credit
            $this->obj->Send['PaymentType']       = 'aio';

            //訂單的商品資料
            foreach ($this->paramer['productList'] as $productKey => $productValue){
                array_push($this->obj->Send['Items'], $productValue);
            }
            //Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
            //以下參數不可以跟信用卡定期定額參數一起設定
            // $obj->SendExtend['CreditInstallment'] = '' ;    //分期期數，預設0(不分期)，信用卡分期可用參數為:3,6,12,18,24
            // $obj->SendExtend['Redeem'] = false ;           //是否使用紅利折抵，預設false
            // $obj->SendExtend['UnionPay'] = false;          //是否為聯營卡，預設false;

            //Credit信用卡定期定額付款延伸參數(可依系統需求選擇是否代入)
            //以下參數不可以跟信用卡分期付款參數一起設定
            // $obj->SendExtend['PeriodAmount'] = '' ;    //每次授權金額，預設空字串
            // $obj->SendExtend['PeriodType']   = '' ;    //週期種類，預設空字串
            // $obj->SendExtend['Frequency']    = '' ;    //執行頻率，預設空字串
            // $obj->SendExtend['ExecTimes']    = '' ;    //執行次數，預設空字串
            $this->obj->CheckOut();
        } catch (Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    /**
     * 付款結果通知
     * 
     */
    public function receive(){
        try {
            $this->obj = new ECPay_AllInOne();
            $this->obj->HashKey     = '5294y06JbISpM5x9';                                    //測試用Hashkey，請自行帶入ECPay提供的HashKey
            $this->obj->HashIV      = 'v77hoKGq4kWxNNIS';                                    //測試用HashIV，請自行帶入ECPay提供的HashIV
            $this->obj->MerchantID  = '2000132';                                              //測試用MerchantID，請自行帶入ECPay提供的MerchantID
            $this->obj->EncryptType = ECPay_EncryptType::ENC_SHA256; // SHA256
            $result = $this->obj->CheckOutFeedback();
            return $result;
        }catch(Exception $e) {
            return $e->getMessage();            
        }
    }
}