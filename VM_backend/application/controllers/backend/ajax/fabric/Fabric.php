<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fabric extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** fabric ********************/
    public function get_fabric_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $fabricId = $this->input->get('fabricId',true);
        $filter = array('like' => array('field' => 'lang.main_title', 'value' => $search),array('field' => 'fabric.fabricId','value' => $fabricId));
        $order = array(array('field' => 'fabric.create_at', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('fabric/tb_fabric_model', 'fabric');
        $fabricList = $this->fabric->get_fabric_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->fabric->count_fabric($filter, $this->langId);
        if ($fabricList):
            foreach ($fabricList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                
                    'preview' => '<div id="preview">' . (!empty($row->firstbannerImg) ? '<img src="' . base_url($row->firstbannerImg) . '" width="200px">' : '') . '</div>',
                    'main_title' => $row->main_title,
                    'action' => $this->get_button('edit', 'backend/fabric/fabric/edit/' . $row->fabricId . $query) . $this->get_button('delete', 'backend/fabric/fabric/delete/' . $row->fabricId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
}