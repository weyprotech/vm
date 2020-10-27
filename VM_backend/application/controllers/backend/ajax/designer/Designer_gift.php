<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Designer_gift extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('designer/tb_designer_model', 'designer');
        $this->load->model('designer/tb_gift_designer_model','gift_designer_model');
        $this->load->model('brand/tb_brand_model','brand');
    }

    /******************** gift ********************/
    public function get_gift_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $startDate = $this->input->get('startDate',true);
        $endDate = $this->input->get('endDate',true);
        $query = $this->set_http_query(array('search' => $search, 'startDate' => $startDate, 'endDate' => $endDate));

        $startDate = empty($startDate) ? '' : 'gift_designer.date >='."'".$this->input->get('startDate',true)."'";
        $endDate = empty($endDate) ? '' : 'gift_designer.date <='."'".$this->input->get('endDate',true)."'";
        if(!empty($startDate) && !empty($endDate))
        {
            if(!empty($search)){
                $searchDate = "and $startDate and $endDate";
            }
            else{
                $searchDate = "$startDate and $endDate";
            }
        }
        else if(!empty($startDate))
        {
            if(!empty($search)){
                $searchDate = "and ".$startDate;
            }
            else{
                $searchDate = $startDate;
            }
        }
        else if(!empty($endDate)){
            if(!empty($search)){
                $searchDate = "and ".$endDate;
            }
            else{
                $searchDate = $endDate;
            }  
        }else{
            $searchDate = '';
        }

        $searchMathod = "((`gift_designer`.`Id` LIKE '%$search%') or (`lang`.`name` LIKE '%$search%') or (`gift_designer`.`trade_no` LIKE '%$search%'))";

        /***** Filter *****/
        $filter = array(
            'other' => array('value' => $searchMathod.$searchDate)
        );
        /***** Order *****/
        $order = array(array('field' => 'gift_designer.create_at', 'dir' => 'desc'));

        $giftList = $this->gift_designer_model->get_gift_designer_select($filter, $order, array('limit' => $limit, 'start' => $start), 3);
        $recordsTotal = $this->gift_designer_model->count_gift_designer($filter, 3);
        if ($giftList):
            foreach ($giftList as $row):
                $data[] = array(
                    'giftId' => $row->Id,
                    'icon' => (!empty($row->designiconImg) ? '<div id="preview"><img src="' . base_url($row->designiconImg) . '"></div>' : ''),
                    'preview' => '<div id="preview">' . (!empty($row->designImg) ? '<img src="' . base_url($row->designImg) . '">' : '') . '</div>',
                    'name' => $row->name,
                    'date' => $row->date,
                    'money' => $row->money,
                    'payment_type_charge_fee' => $row->payment_type_charge_fee,
                    'trade_money' => $row->trade_amount,
                    'trade_no' => $row->trade_no,
                    'action' => $this->get_button('edit', 'backend/designer/gift/edit/' . $row->Id . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    /******************** End designer ********************/
}