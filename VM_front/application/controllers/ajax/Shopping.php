<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shopping extends Ajax_Controller
{
    public function __construct()
    {        
        parent::__construct();
        $this->load->model('product/tb_product_model','tb_product_model');
    }

    public function addtocart()
	{
		if($this->input->post('productid'))
		{
			$productid = $this->input->post('productid');
			$quantity = $this->input->post('quantity');
            $size = $this->input->post('size');
            $color = $this->input->post('color');
			
			$row = $this->tb_product_model->get_product_by_id($productid, $this->langId);

			$data = array(
				'id' => $row->productId,
				'name' => $row->name,
				'qty' => $quantity,
				'size' => $size,
				'color' => $color,
				'price' => $row->price,
				'productImg' => $row->productImg
			);
			
			$rowid = $this->cart->insert($data);

			$result = array(
				'code' => "200",
				'rowid' => $rowid,
                'contents' => $this->cart->contents(),
				'quantitytotal' => $this->cart->total_items()
			);
			
			echo json_encode($result);
			return false;
		}
    }
    
    public function removecart()
	{
		if($this->input->post('rowid'))
		{
			$rowid = $this->input->post('rowid');
			
			$this->cart->remove($rowid);

			$result = array(
                'code' => "200",
                'contents' => $this->cart->contents(),
				'quantitytotal' => $this->cart->total_items(),
				'total' => $this->cart->total()
			);
			
			echo json_encode($result);
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
			
			$this->cart->update($data);
			
			$result = array(
                'code' => "200",
                'contents' => $this->cart->contents(),
				'quantitytotal' => $this->cart->total_items(),
				'total' => $this->cart->total()
			);
			
			echo json_encode($result);
			return false;
		}	
    }
}