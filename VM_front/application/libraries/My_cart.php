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
            $this->_cart_contents = array('product_list' => array(),'amount' => 0,'total' => 0);
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
     * 取得總額
     * 
     * @return int
     */
    public function total(){
        return $this->_cart_contents['total'];
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
                    'productPrice' => $productList[$productValue->productId]['price'],
                    'productIntroduction' => $productValue->introduction,
                    'productmainName' => $productValue->mainName,
                    'productminorName' => $productValue->minorName,
                    'productbaseName' => $productValue->baseName,
                    'productImg' => $productValue->productImg,
                    'productSize' => $productList[$productValue->productId]['size'],
                    'productColor' => $productList[$productValue->productId]['color'],
                    'productQty' => $productList[$productValue->productId]['qty']
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
                    'color' => $item['color']
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
        if(!isset($productList['productId'])){
            return $this->_set_result('not found product');
        }
        try{
            $this->_cart_contents['product_list'][$item['prductId']]['qty'] = $item['qty'];
            $this->_cart_contents['product_list'][$item['prductId']]['size'] = $item['size'];
            $this->_cart_contents['product_list'][$item['prductId']]['color'] = $item['color'];
            $this->_calc_cart();
        }catch(Exception $e){
            $this->_set_result($e->getMessage());
        }
    }

    /**
     * 刪除購物車
     * 
     * @param array('$prductId')
     */
    public function delete_cart($item){
        if(!is_array($item)){
            return $this->_set_result('Item error');
        }
        try{
            unset($this->_cart_contents['product_list'][$item['prductId']]);
            $this->_calc_cart();
        }catch(Exception $e){
            return $this->_set_result($e->getMessage());
        }            
    }


    /**
     * 計算總金額
     * 
     */
    private function _calc_cart(){
        $amount = $total = 0;

        $productList = $this->_cart_contents['product_list'];
        foreach ($productList as $productKey => $productValue){
            $amount += $productValue['qty'];
            $total += $productValue['qty']*$productValue['price'];            
        }
        $this->_cart_contents['amount'] = $amount;
        $this->_cart_contents['total'] = $total;
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