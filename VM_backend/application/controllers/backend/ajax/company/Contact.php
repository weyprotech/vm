<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** contact ********************/
    public function get_contact_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));        

        $this->load->model('company/tb_contact_model', 'contact_model');

       
        $filter['like'] = array('field' => 'lang.title', 'value' => $search);
        
        $order = array(array('field' => 'contact.create_at', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));
        
        $contactList = $this->contact_model->get_contact_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->contact_model->count_contact($filter, $this->langId);

        if ($contactList):
            foreach ($contactList as $row):
                $data[] = array(                    
                    'name' => $row->name,
                    'email' => $row->email,
                    'phone' => $row->phone_area_code.'-'.$row->phone,
                    'topic' => $row->topic,
                    'contact_type' => $row->contact_type == 0 ? 'email' : 'phone',
                    'action' => $this->get_button('view', 'backend/company/contact/view/' . $row->Id . $query) . $this->get_button('delete', 'backend/company/contact/delete/' . $row->Id . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    function get_contact_order()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('tb_contact_model', 'contact');

        $minorId = $this->input->get('minorId');
        echo json_encode(array('order' => $this->contact->count_contact(array(array('field' => 'contact.cId', 'value' => $minorId))) + 1));
        return true;
    }
}