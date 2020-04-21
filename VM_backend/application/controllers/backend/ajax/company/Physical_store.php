<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class physical_store extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** physical_store ********************/
    public function get_physical_store_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));        

        $this->load->model('company/tb_physical_store_model', 'physical_store');

       
        $filter['like'] = array('field' => 'lang.title', 'value' => $search);
        
        $order = array(array('field' => 'physical_store.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        
        $physical_storeList = $this->physical_store->get_physical_store_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->physical_store->count_physical_store($filter, $this->langId);

        if ($physical_storeList):
            foreach ($physical_storeList as $row):
                $data[] = array(                    
                    'title' => $row->title,
                    'address' => $row->address,
                    'phone' => $row->phone,
                    'time' => $row->time,
                    'order' => $this->get_order('physical_store', $row->physical_storeId, $row->order),
                    'action' => $this->get_button('edit', 'backend/company/physical_store/edit/' . $row->physical_storeId . $query) . $this->get_button('delete', 'backend/company/physical_store/delete/' . $row->physical_storeId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    function get_physical_store_order()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('tb_physical_store_model', 'physical_store');

        $minorId = $this->input->get('minorId');
        echo json_encode(array('order' => $this->physical_store->count_physical_store(array(array('field' => 'physical_store.cId', 'value' => $minorId))) + 1));
        return true;
    }
}