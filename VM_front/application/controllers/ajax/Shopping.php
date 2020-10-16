<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shopping extends Ajax_Controller
{
    public function __construct()
    {        
        parent::__construct();
		$this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('product/tb_sale_model','tb_sale_model');
		$this->load->model('shipping/tb_shipping_model','tb_shipping_model');
		$this->load->library('my_cart');
    }

	//新增產品至購物車
    public function addtocart()
	{
		if($this->input->post('productid'))
		{
			$productid = $this->input->post('productid');
			$quantity = $this->input->post('quantity');
            $sizeid = $this->input->post('size');
			$colorid = $this->input->post('color');
			$status = $this->input->post('status');
			
			$row = $this->tb_product_model->get_product_by_id($productid, $this->langId);
			$color = $this->tb_product_model->get_product_color_by_id($colorid,$this->langId);
			$size = $this->tb_product_model->get_product_size_by_id($sizeid,$this->langId);
			$saleinformation = $this->tb_sale_model->get_sale_information();
			if($saleinformation->is_visible == 1){
				$sale = $this->tb_sale_model->get_sale_product_by_pId($productid);
			}else{
				$sale = false;
			}
			//現貨價格、15天後價格
			if($status == 0){
				$price = $row->price;
			}else{
				$price = $row->fifteen_price;
			}

			if($sale){
				$this->my_cart->add_cart(array('productId' => $productid,'price' =>(($price)-($price*($saleinformation->discount/100))) ,'size' => $size->size,'qty' => $quantity,'color' => $color->color,'status' => $status));				
			}else{
				$this->my_cart->add_cart(array('productId' => $productid,'price' => $price,'size' => $size->size,'qty' => $quantity,'color' => @$color->color,'status' => $status));
			}

			//購物車
			$cart_productList = $this->my_cart->get_product_list();
			$cart_amount = $this->my_cart->amount();
			$cart_total = $this->my_cart->total();

			echo json_encode(array('status' => 'success','cart_productList' => $cart_productList,'cart_amount' => $cart_amount,'cart_total' => $cart_total));
			return true;
		}
    }
	
	//刪除購物車產品
    public function deletetocart()
	{
		if($this->input->post('productid'))
		{
			$productid = $this->input->post('productid');
			
			$this->my_cart->delete_cart(array('productId' => $productid));

			//購物車
			$cart_productList = $this->my_cart->get_product_list();
			$cart_amount = $this->my_cart->amount();
			$cart_total = $this->my_cart->total();
			$all_total = $this->my_cart->all_total();
			
			echo json_encode(array('status' => 'success','cart_productList' => $cart_productList,'cart_amount' => $cart_amount,'cart_total' => $cart_total,'all_total' => $all_total));
			return true;
		}
	}

	//更新購物車
	public function updatecart()
	{
		if($this->input->post('productid'))
		{
			$productid = $this->input->post('productid');
			$size = $this->input->post('size');
			$color = $this->input->post('color');
			$quantity = $this->input->post('quantity');

			$this->my_cart->update_cart(array(
				'productId' => $productid,
				'size' => $size,
				'color' => $color,
				'qty' => $quantity
 			));

			//購物車			
			$cart_productList = $this->my_cart->get_product_list();
			$cart_amount = $this->my_cart->amount();
			$cart_total = $this->my_cart->total();
			$all_total = $this->my_cart->all_total();

			echo json_encode(array('status' => 'success','cart_productList' => $cart_productList,'cart_amount' => $cart_amount,'cart_total' => $cart_total,'all_total' => $all_total));
			return true;
		}
	}
	
	//更新購物車運費
	public function update_cart_shipping(){
		$shippingId = $this->input->post('shipping');
		$shipping = $this->tb_shipping_model->get_shipping_by_id($shippingId,$this->langId);
		$shipping_array = array('shippingId' => $shippingId,'money' => $shipping->money,'original_money' => $shipping->money);
		$this->my_cart->update_shipping($shipping_array);
		$all_total = $this->my_cart->all_total();
		echo json_encode(array('status' => 'success','all_total' => $all_total,'money' => round($shipping->money*$this->session->userdata('currency'))));
		return true;
	}
}