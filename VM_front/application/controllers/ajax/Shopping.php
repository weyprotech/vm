<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shopping extends Ajax_Controller
{
    public function __construct()
    {        
        parent::__construct();
		$this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('product/tb_sale_model','tb_sale_model');

		$this->load->library('my_cart');
    }

    public function addtocart()
	{
		if($this->input->post('productid'))
		{
			$productid = $this->input->post('productid');
			$quantity = $this->input->post('quantity');
            $sizeid = $this->input->post('size');
            $colorid = $this->input->post('color');
			
			$row = $this->tb_product_model->get_product_by_id($productid, $this->langId);
			$color = $this->tb_product_model->get_product_color_by_id($colorid,$this->langId);
			$size = $this->tb_product_model->get_product_size_by_id($sizeid,$this->langId);
			$saleinformation = $this->tb_sale_model->get_sale_information();
			if($saleinformation->is_visible == 1){
				$sale = $this->tb_sale_model->get_sale_product_by_pId($productid);
			}else{
				$sale = false;
			}
			if($sale){
				$this->my_cart->add_cart(array('productId' => $productid,'price' =>(($row->price)-($row->price*($saleinformation->discount/100))) ,'size' => $size->size,'qty' => $quantity,'color' => $color->color));				
			}else{
				$this->my_cart->add_cart(array('productId' => $productid,'price' => $row->price,'size' => $size->size,'qty' => $quantity,'color' => $color->color));
			}

			//購物車
			$cart_productList = $this->my_cart->get_product_list();
			$cart_amount = $this->my_cart->amount();
			$cart_total = $this->my_cart->total();

			echo json_encode(array('status' => 'success','cart_productList' => $cart_productList,'cart_amount' => $cart_amount,'cart_total' => $cart_total));
			return false;
		}
    }
    
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
			
			echo json_encode(array('status' => 'success','cart_productList' => $cart_productList,'cart_amount' => $cart_amount,'cart_total' => $cart_total));
			return false;
		}
	}
	
	public function updatecart()
	{
		if($this->input->post('rowid'))
		{
			$rowid = $this->input->post('rowid');
			$qty = $this->input->post('qty');

			$data = array(
				'rowid' => $rowid,
				'qty' => $qty
			);
			
			$this->my_cart->update($data);
			
			$result = array(
                'code' => "200",
                'contents' => $this->my_cart->contents(),
				'quantitytotal' => $this->my_cart->total_items(),
				'total' => $this->my_cart->total()
			);
			
			echo json_encode($result);
			return false;
		}	
    }
}