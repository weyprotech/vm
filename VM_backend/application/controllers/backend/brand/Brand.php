<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->check_action_auth($this->prevId, 'view', true); // Check Auth
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->load->model('brand/tb_brand_model', 'brand_model');
        $this->load->model('designer/tb_designer_model','designer_model');
        $this->load->model('tb_location_model','location_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $brandId = uniqid();
        $locationList = $this->location_model->get_location_select(array(array('field' => 'tb_location.is_use','value' => 0)),false,false);

        $designerList = $this->designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1)),false,false,$this->langId);
        if($post = $this->input->post(null,true)){
            $location = $this->location_model->get_location_by_id($post['locationId']);
            $this->location_model->update_location($location,array('is_use' => 1));
            $this->brand_model->insert_brand($post);            
            $brandId = $post['brandId'];
            if($this->input->get('back',true)){                
                redirect("backend/brand/brand");
            }            
            redirect('backend/brand/brand/edit/' . $brandId . $this->query);
        }
        $this->get_view('add',array('brandId' => $brandId,'designerList' => $designerList,'locationList' => $locationList));
    }

    public function edit($brandId = false)
    {
        if(!$row = $this->brand_model->get_brand_by_id($brandId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/brand/brand');
        endif;
        $designerList = $this->designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1)),false,false,$this->langId);
        $location = $this->location_model->get_location_by_id($row->locationId);
        $locationList = $this->location_model->get_location_select(array(array('field' => 'tb_location.is_use','value' => 0)),false,false);

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth
            //先把原本的地點更新沒使用
            $location = $this->location_model->get_location_by_id($row->locationId);
            $this->location_model->update_location($location,array('is_use' => 0));
            
            //把選取的換成使用中
            $location = $this->location_model->get_location_by_id($post['locationId']);
            $this->location_model->update_location($location,array('is_use' => 1));

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->brand_model->update_brand($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/brand/brand' . $this->query);
                endif;
            endif;

            redirect('backend/brand/brand/edit/' . $brandId . $this->query);
        endif;

        $data = array(
            'brandId' => $brandId,
            'row' => $row,
            'designerList' => $designerList,
            'locationList' => $locationList,
            'location' => $location
        );

        $this->get_view('edit', $data);
    }

    public function delete($brandId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->brand_model->get_brand_by_id($brandId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->brand_model->delete_brand($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/brand/brand' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('brandOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_brand', $order, 'brandId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/brand/brand' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/brand/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}