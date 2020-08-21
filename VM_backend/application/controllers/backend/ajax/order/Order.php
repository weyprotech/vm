<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** order ********************/
    public function get_order_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $this->load->model('order/tb_order_model', 'order');

        $filter['like'] = array('field' => 'lang.name', 'value' => $search);
        
        $order = array(array('field' => 'order.date', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));

        
        $orderList = $this->order->get_order_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->order->count_order($filter, $this->langId);

        if ($orderList):
            foreach ($orderList as $row):
                switch ($row->status){
                    case '0':
                        $status = '尚未付款';
                        break;
                    case '1':
                        $status = '待確認付款';
                        break;
                    case '2':
                        $status = '已付款';
                        break;
                }
                $data[] = array(
                    'orderid' => $row->orderId,
                    'date' => $row->date,
                    'total' => $row->total,
                    'status' => $status,
                    'country' => $row->country,
                    'name' => $row->first_name.' '.$row->last_name,
                    'phone' => $row->phone,
                    'action' => $this->get_button('edit', 'backend/order/order/edit/' . $row->orderId . $query) . $this->get_button('delete', 'backend/order/order/delete/' . $row->orderId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    /******************** End order ********************/
}