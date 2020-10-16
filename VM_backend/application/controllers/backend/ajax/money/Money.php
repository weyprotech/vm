<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Money extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** money ********************/
    public function get_money_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $moneyId = $this->input->get('moneyId',true);
        $filter = array(array('field' => 'money.moneyId','value' => $moneyId));
        $order = array(array('field' => 'money.create_at', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('money/tb_money_model', 'money');
        $moneyList = $this->money->get_money_select($filter, $order, array('limit' => $limit, 'start' => $start));
        $recordsTotal = $this->money->count_money($filter);
        if ($moneyList):
            foreach ($moneyList as $row):
                $data[] = array(                    
                    'action' => $this->get_button('edit', 'backend/money/money/edit/' . $row->moneyId . $query) . $this->get_button('delete', 'backend/money/money/delete/' . $row->moneyId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
}