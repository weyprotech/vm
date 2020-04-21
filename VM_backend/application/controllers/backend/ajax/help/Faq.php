<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** faq ********************/
    public function get_faq_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $faqId = $this->input->get('faqId',true);
        $filter = array('like' => array('field' => 'lang.title', 'value' => $search),array('field' => 'faq.faqId','value' => $faqId));
        $order = array(array('field' => 'faq.order', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('help/tb_faq_model', 'faq_model');
        $faqList = $this->faq_model->get_faq_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->faq_model->count_faq($filter, $this->langId);
        if ($faqList):
            foreach ($faqList as $row):
                $data[] = array(
                    'title' => $row->title,
                    'content' => $row->content,
                    'order' => $this->get_order('faq', $row->faqId, $row->order),
                    'action' => $this->get_button('edit', 'backend/help/faq/edit/' . $row->faqId . $query) . $this->get_button('delete', 'backend/help/faq/delete/' . $row->faqId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
}