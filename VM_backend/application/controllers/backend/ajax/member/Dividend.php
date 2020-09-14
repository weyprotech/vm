<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dividend extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** dividend ********************/
    public function get_dividend_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $this->load->model('member/tb_dividend_model', 'dividend_model');
        $filter['like'] = array('field' => 'lang.name', 'value' => $search);        
        $order = array(array('field' => 'dividend.create_at', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        
        $dividendList = $this->dividend_model->get_dividend_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->dividend_model->count_dividend($filter, $this->langId);

        if ($dividendList):
            foreach ($dividendList as $row):
                $data[] = array(                    
                    'order' => '<a href="'.site_url('backend/order/order/edit/'.$row->orderId).'">'.$row->orderId.'</a>',
                    'dividend' => $row->dividend,
                    'action' => $this->get_button('delete', 'backend/dividend/dividend/delete/' . $row->dividendId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
}