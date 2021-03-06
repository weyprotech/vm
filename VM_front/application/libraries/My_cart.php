<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_cart
{
    /**
     * 引用 CI 實作
     * 
     * @var object
     */
    protected $CI;

    /**
     * 購物車內容
     * 
     * @var array
     */
    protected $_cart_contents = array();

    /**
     * 運送費用
     * 
     * @var array
     */
    public $shipping_fee = array();

    /**
     * 動作執行結果
     * 
     * @var array
     */
    protected $_result = array('status' => TRUE,'message' => '');

    /**
     * Cart Class Constructor
     * 
     * The constructor loads the Session class, used to store the shopping cart contents.
     * 
     * @param array   $params = array()
     * 
     * @return void
     */
    public function __construct($params = array()){
        $this->CI = &get_instance();

        $this->_cart_contents = $this->CI->session->userdata('cart_contents');
        if($this->_cart_contents == NULL){
            $this->_cart_contents = array('product_list' => array(),'shipping' => array(),'dividend' => 0,'coupon' => array(),'amount' => 0,'total' => 0,'original_total' => 0,'all_total' => 0,'original_all_total' => 0,'currency' => '');
        }

        $this->CI->load->model(array(
            'product/tb_product_model' => 'product_model'
        ));        
    }

    /**
     * 取得訂單編號
     * 
     * 
     */
    public function get_orderNumber(){
        return $this->CI->session->userdata('order_number');
    } 

    /**
     * 取得購物車產品總數
     *
     *  @return int
     */
    public function amount(){
        return $this->_cart_contents['amount'];
    }

    /**
     * 取得美金總額
     * 
     * @return int
     */
    public function original_total(){
        return round($this->_cart_contents['original_total']);
    }

    /**
     * 取得商品總額
     * 
     * @return int
     */
    public function total(){
        return round($this->_cart_contents['total']);
    }

    /**
     * 取得含運費的美金總額
     * 
     * @return int
     */
    public function original_all_total(){
        return round($this->_cart_contents['original_all_total']);
    }

    /**
     * 取得含運費的總額
     * 
     * @return int
     */
    public function all_total(){
        return round($this->_cart_contents['all_total']);
    }

    /**
     * 取得運費
     * 
     * @return array()
     */
    public function shipping(){
        return $this->_cart_contents['shipping'];
    }

    /**
     * 取得紅利
     * 
     * @return int
     */
    public function dividend(){
        return $this->_cart_contents['dividend'];
    }

    /**
     * 取得折扣碼
     * 
     * @return int
     */
    public function coupon(){
        return $this->_cart_contents['coupon'];
    }

    /**
     * 取得貨幣類別
     * 
     * @return string
     */
    public function currency(){
        return $this->_cart_contents['currency'];
    }

    /**
     * 取得購物車產品列表
     * 
     * @return array
     */
    public function get_product_list(){
        $productList = $this->_cart_contents['product_list'];
        $productArray = array();
        if($productList){
            $products = $this->CI->product_model->get_product_select(
                array(array('field' => 'product.is_visible','value' => 1),'whereIn' => array('field' => 'product.productId','value' => array_keys($productList)))
                ,false,false,$this->CI->langId
            );

            foreach($products as $productKey => $productValue){
                $productArray[$productValue->productId] = array(
                    'productId' => $productValue->productId,
                    'productName' => $productValue->name,
                    'productPrice' => round($productList[$productValue->productId]['price'] * $this->CI->session->userdata('currency')),
                    'productOriginalPrice' => $productList[$productValue->productId]['price'],
                    'productIntroduction' => $productValue->introduction,
                    'productmainName' => $productValue->mainName,
                    'productminorName' => $productValue->minorName,
                    'productbaseName' => $productValue->baseName,
                    'productImg' => $productValue->productImg,
                    'productSize' => $productList[$productValue->productId]['size'],
                    'productColor' => $productList[$productValue->productId]['color'],
                    'productQty' => $productList[$productValue->productId]['qty'],
                    'productStatus' => $productList[$productValue->productId]['status']
                );
            }
        }
        return $productArray;
    }
    

    /**
     * 加入購物車
     * 
     * @param array('productId','price','qty','size','color')
     */
    public function add_cart($item){
        if(!is_array($item)){
            return $this->_set_result('Item error');
        }
        $productList = $this->_cart_contents['product_list'];
        $productList[$item['productId']] = $item;        
        if($product = $this->CI->product_model->get_product_by_id($item['productId'])){
            try{
                $this->_cart_contents['product_list'][$item['productId']] = array(
                    'productId' => $item['productId'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'status' => $item['status'],
                );
                $this->_calc_cart();
            }catch(Exception $e){
                return $this->_set_result($e->getMessage());
            }
        }else{
            return $this->_set_result('can not found product');
        }
    }

    /**
     * 更新購物車
     * 
     * @param array('productId','qty','size','color')
     */
    public function update_cart($item){
        if(!is_array($item)){
            return $this->_set_result('Item error');            
        }
        $productList = $this->_cart_contents['product_list'];
        if(!isset($productList[$item['productId']])){
            return $this->_set_result('not found product');
        }
        try{ 
            $this->_cart_contents['product_list'][$item['productId']]['qty'] = $item['qty'];
            $this->_cart_contents['product_list'][$item['productId']]['size'] = $item['size'];
            $this->_cart_contents['product_list'][$item['productId']]['color'] = $item['color'];   
            $this->_calc_cart();
        }catch(Exception $e){
            $this->_set_result($e->getMessage());
        }
    }

    /**
     * 刪除購物車
     * 
     * @param array('$productId')
     */
    public function delete_cart($item){
        if(!is_array($item)){
            return $this->_set_result('Item error');
        }
        try{
            unset($this->_cart_contents['product_list'][$item['productId']]);
            $this->_calc_cart();
        }catch(Exception $e){
            return $this->_set_result($e->getMessage());
        }
    }

    /**
     * 重置購物車
     * 
     * 
     */
    public function reset_cart(){
        $this->CI->session->set_userdata('cart_contents','');
    }

    /**
     * 更新運費
     * 
     * @param array('shippingId','money')
     */
    public function update_shipping($shipping = false){
        if($shipping){
            $this->_cart_contents['shipping'] = $shipping;
        }
        if(isset($this->_cart_contents['shipping']['money'])){
            $this->_cart_contents['shipping']['money'] = round($this->_cart_contents['shipping']['original_money'] * $this->CI->session->userdata('currency'));            
        }
        $this->_calc_cart();
    }

    /**
     * 使用紅利
     * 
     * @param int
     */
    public function update_dividend($dividend){
        $this->_cart_contents['dividend'] = $dividend * $this->CI->session->userdata('currency');
        $this->_calc_cart();
    }

    /**
     * 使用折價券
     * 
     * @param array
     */
    public function update_coupon($coupon){
        $this->_cart_contents['coupon'] = $coupon;
        $this->_cart_contents['coupon']['money'] = $coupon['money'] * $this->CI->session->userdata('currency');
        $this->_calc_cart();
    }

    /**
     * 重置紅利
     * 
     *
     */
    public function reset_dividend(){
        $this->_cart_contents['dividend'] = 0;
        $this->_calc_cart();
    }

    /**
     * 重置折價券
     * 
     *
     */
    public function reset_coupon(){
        $this->_cart_contents['coupon'] = array();
        $this->_calc_cart();
    }


    /**
     * 計算總金額
     * 
     */
    public function _calc_cart(){
        $amount = $total = $alltotal = $original_total = $original_all_total = 0;

        $productList = $this->_cart_contents['product_list'];
        foreach ($productList as $productKey => $productValue){
            $amount += $productValue['qty'];
            $original_total = $productValue['qty']*$productValue['price'];
            $total += round($productValue['qty']*$productValue['price'] * $this->CI->session->userdata('currency'));
        }
        //運費
        if(!empty($this->_cart_contents['shipping'])){
            $alltotal = $total+$this->_cart_contents['shipping']['money'];
            $original_all_total = $original_total+$this->_cart_contents['shipping']['original_money'];
        }else{
            $alltotal = $total;
            $original_all_total = $original_total;
        }
        //紅利
        if(!empty($this->_cart_contents['dividend'])){
            $alltotal = $alltotal-$this->_cart_contents['dividend'];
            $original_all_total = $original_all_total-($this->_cart_contents['dividend'] / $this->CI->session->userdata('currency'));
        }else{
            $alltotal = $alltotal;
            $original_all_total = $original_all_total;
        }
        //折價券
        if(!empty($this->_cart_contents['coupon'])){
            $alltotal = $alltotal-$this->_cart_contents['coupon']['money'];
            $original_all_total = $original_all_total-($this->_cart_contents['coupon']['money'] / $this->CI->session->userdata('currency'));
        }else{
            $alltotal = $alltotal;
            $original_all_total = $original_all_total;
        }
        $this->_cart_contents['amount'] = $amount;
        $this->_cart_contents['total'] = $total;
        $this->_cart_contents['all_total'] = $alltotal;
        $this->_cart_contents['currency'] = $this->CI->session->userdata('money_type');
        $this->_cart_contents['original_total'] = $original_total;
        $this->_cart_contents['original_all_total'] = $original_all_total;
        $this->CI->session->set_userdata('cart_contents',$this->_cart_contents);
    }

    /**
     * 設定錯誤訊息
     * 
     * @param string $message
     * 
     */
    private function _set_result($message = ''){
        $this->_result['status'] = empty($message);
        $this->_result['message'] = $message;
        return $this->_result;
    }
}