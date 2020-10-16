<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manufacturer extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** manufacturer ********************/
    public function get_manufacturer_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $manufacturerId = $this->input->get('manufacturerId',true);
        $filter = array('like' => array('field' => 'lang.main_title', 'value' => $search),array('field' => 'manufacturer.manufacturerId','value' => $manufacturerId));
        $order = array(array('field' => 'manufacturer.create_at', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('manufacturer/tb_manufacturer_model', 'manufacturer');
        $manufacturerList = $this->manufacturer->get_manufacturer_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->manufacturer->count_manufacturer($filter, $this->langId);
        if ($manufacturerList):
            foreach ($manufacturerList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                
                    'preview' => '<div id="preview">' . (!empty($row->firstbannerImg) ? '<img src="' . base_url($row->firstbannerImg) . '" width="200px">' : '') . '</div>',
                    'main_title' => $row->main_title,
                    'action' => $this->get_button('edit', 'backend/manufacturer/manufacturer/edit/' . $row->manufacturerId . $query) . $this->get_button('delete', 'backend/manufacturer/manufacturer/delete/' . $row->manufacturerId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
}