<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shipping extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** shipping ********************/
    public function get_shipping_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $this->load->model('shipping/tb_shipping_model', 'shipping');

        $filter['like'] = array('field' => 'lang.name', 'value' => $search);
        
        $order = array(array('field' => 'shipping.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        
        $shippingList = $this->shipping->get_shipping_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->shipping->count_shipping($filter, $this->langId);

        if ($shippingList):
            foreach ($shippingList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                    'name' => $row->name,
                    'money' => $row->money,                   
                    'order' => $this->get_order('shipping', $row->shippingId, $row->order),
                    'action' => $this->get_button('edit', 'backend/shipping/shipping/edit/' . $row->shippingId . $query) . $this->get_button('delete', 'backend/shipping/shipping/delete/' . $row->shippingId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    /******************** End shipping ********************/
}