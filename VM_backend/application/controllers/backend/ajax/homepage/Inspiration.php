<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inspiration extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** inspiration ********************/
    public function get_inspiration_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));        
        $filter = array('like' => array('field' => 'lang.title', 'value' => $search));
        $order = array(array('field' => 'inspiration.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('homepage/tb_inspiration_model', 'inspiration');
        $inspirationList = $this->inspiration->get_inspiration_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->inspiration->count_inspiration($filter, $this->langId);
        if ($inspirationList):
            foreach ($inspirationList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                
                    'preview' => '<div id="preview">' . (!empty($row->inspirationImg) ? '<img src="' . base_url($row->inspirationImg) . '" width="200px">' : '') . '</div>',
                    'title' => $row->title,
                    'order' => $this->get_order('inspiration', $row->inspirationId, $row->order),
                    'action' => $this->get_button('edit', 'backend/homepage/inspiration/edit/' . $row->inspirationId . $query) . $this->get_button('delete', 'backend/homepage/inspiration/delete/' . $row->inspirationId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    public function upload()
    {
        $inspirationId = $this->input->post('inspirationId', true);
        if ($inspirationId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                $this->uploadPath = 'assets/uploads/homepage/inspiration/';
                $filePath = $this->uploadImg($_FILES['file'], $inspirationId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }
}