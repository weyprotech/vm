<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->check_action_auth($this->prevId, 'view', true); // Check Auth
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->load->model('order/tb_order_model', 'order_model');
        $this->load->model('money/tb_money_model','money_model');
        $this->load->model('coupon/tb_coupon_model','coupon_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $data = array(
            'page' => $this->input->get('page', true),
            'startDate' => $this->input->get('startDate',true),
            'endDate' => $this->input->get('endDate',true)
        );
        $this->get_view('index',$data);
    }

    public function edit($orderId = false)
    {
        if (!$row = $this->order_model->get_order_by_id($orderId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/order/order');
        endif;        

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->order_model->update_order($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/order/order' . $this->query);
                endif;
            endif;

            redirect('backend/order/order/edit/' . $orderId . $this->query);
        endif;

        //貨幣匯率
        $this->moneyList = $this->money_model->get_money_select(false,false,false);
        switch($row->currency){
            case 'eur':
                $currency = $this->moneyList[0]->eur_value;
                break;
            case 'twd':
                $currency = $this->moneyList[0]->twd_value;
                break;
            default:
                $currency = 1;
        }

        //折價券
        $coupon = $this->coupon_model->get_coupon_by_id($row->couponId);

        $productList = $this->order_model->get_backend_product(array(array('field' => 'order_product.orderId','value' => $orderId)),$this->langId);
        $data = array(
            'orderId' => $orderId,
            'row' => $row, 
            'productList' => $productList,
            'currency' => $currency,
            'coupon' => $coupon
        );

        $this->get_view('edit', $data);
    }

    public function delete($orderId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->order_model->get_order_by_id($orderId, false, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->order_model->delete_order($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/order/order' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('orderOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_order', $order, 'orderId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/order/order' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/order/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}