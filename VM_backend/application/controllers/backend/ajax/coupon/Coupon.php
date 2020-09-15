<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** coupon ********************/
    public function get_coupon_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $this->load->model('coupon/tb_coupon_model', 'coupon');

        $filter['like'] = array('field' => 'lang.name', 'value' => $search);
        
        $order = array(array('field' => 'coupon.update_at', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));

        
        $couponList = $this->coupon->get_coupon_select($filter, $order, array('limit' => $limit, 'start' => $start));
        $recordsTotal = $this->coupon->count_coupon($filter, $this->langId);

        if ($couponList):
            foreach ($couponList as $row):
                $data[] = array(
                    'usable' => '<td><img src="' . show_enable_image($row->usable) . '" width="25"></td>',
                    'code' => $row->code,
                    'money' => $row->coupon_money,
                    'action' => $this->get_button('edit', 'backend/coupon/coupon/edit/' . $row->couponId . $query) . $this->get_button('delete', 'backend/coupon/coupon/delete/' . $row->couponId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    /******************** End coupon ********************/
}