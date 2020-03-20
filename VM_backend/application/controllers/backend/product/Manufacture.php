<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manufacture extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('product/tb_product_model', 'product_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function edit($pId = false)
    {
        if (!$row = $this->product_model->get_product_manufacture_by_pid($pId)):
            $id = $this->product_model->insert_product_manufacture($pId);
            $row = $this->product_model->get_product_manufacture_by_id($id); 
        endif;

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->product_model->update_product_manufacture($row, $post);
                $this->set_active_status('success', 'Success');
            endif;

            redirect('backend/product/manufacture/edit/' . $pId . $this->query);
        endif;

        $data = array(
            'pId' => $pId,
            'row' => $row
        );

        $this->get_view('edit', $data);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/product/manufacture/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}