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
        $status = $this->input->post('status',true);
        $this->load->model('order/tb_order_model', 'order');

        $filter = array(
                    array('field' => 'order.status', 'value' => $status),
                    'other' => array('value' => "(`order`.`orderId` LIKE '%$search%' or `order`.`first_name` LIKE '%$search%' or `order`.`country` LIKE '%$search%' or `order`.`phone` LIKE '%$search%')")
                );
        
        $order = array(array('field' => 'order.create_at', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));

        $orderList = $this->order->get_order_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->order->count_order($filter, $this->langId);

        if ($orderList):
            foreach ($orderList as $row):
                switch ($row->status){
                    case '0':
                        $row_status = 'Not paid yet';
                        break;
                    case '1':
                        $row_status = 'Paid';
                        break;
                    case '2':
                        $row_status = 'Delivered';
                        break;
                    case '3':
                        $row_status = 'Finished';
                        break;
                }
                $data[] = array(
                    'orderid' => $row->orderId,
                    'date' => $row->date,
                    'currency' => strtoupper($row->currency),
                    'total' => $row->total,
                    'status' => $row_status,
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