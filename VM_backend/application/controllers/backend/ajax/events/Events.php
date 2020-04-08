<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** events ********************/
    public function get_events_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $eventId = $this->input->get('eventId',true);
        $filter = array('like' => array('field' => 'lang.title', 'value' => $search),array('field' => 'events.eventId','value' => $eventId));
        $order = array(array('field' => 'events.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('events/tb_events_model', 'events');
        $eventsList = $this->events->get_events_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->events->count_events($filter, $this->langId);
        if ($eventsList):
            foreach ($eventsList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                
                    'preview' => '<div id="preview">' . (!empty($row->eventImg) ? '<img src="' . base_url($row->eventImg) . '" width="200px">' : '') . '</div>',
                    'title' => $row->title,
                    'date' => $row->date,
                    'order' => $this->get_order('event', $row->eventId, $row->order),
                    'action' => $this->get_button('edit', 'backend/events/events/edit/' . $row->eventId . $query) . $this->get_button('delete', 'backend/events/events/delete/' . $row->eventId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
}