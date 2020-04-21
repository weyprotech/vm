<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** feedback ********************/
    public function get_feedback_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));        

        $this->load->model('help/tb_feedback_model', 'feedback_model');

       
        $filter['like'] = array('field' => 'lang.title', 'value' => $search);
        
        $order = array(array('field' => 'feedback.create_at', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));
        
        $feedbackList = $this->feedback_model->get_feedback_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->feedback_model->count_feedback($filter, $this->langId);

        if ($feedbackList):
            foreach ($feedbackList as $row):
                $data[] = array(                    
                    'name' => $row->name,
                    'email' => $row->email,
                    'phone' => $row->phone_area_code.'-'.$row->phone,
                    'topic' => $row->topic,
                    'contact_type' => $row->contact_type == 0 ? 'email' : 'phone',
                    'action' => $this->get_button('view', 'backend/help/feedback/view/' . $row->Id . $query) . $this->get_button('delete', 'backend/help/feedback/delete/' . $row->Id . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    function get_feedback_order()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('tb_feedback_model', 'feedback');

        $minorId = $this->input->get('minorId');
        echo json_encode(array('order' => $this->feedback->count_feedback(array(array('field' => 'feedback.cId', 'value' => $minorId))) + 1));
        return true;
    }
}