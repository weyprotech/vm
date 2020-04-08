<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('brand/tb_brand_banner_model', 'banner');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index($brandId)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index',array('brandId' => $brandId));
    }

    public function add($brandId)
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $bannerId = uniqid();
        if($post = $this->input->post(null,true)){
            $post['brandId'] = $brandId;
            $this->banner->insert_brand_banner($post);
            if($this->input->get('back',true)){
                redirect("backend/brand/banner/index/".$brandId);
            }
            redirect('backend/brand/banner/edit/' . $bannerId . $this->query);
        }        
        $this->get_view('add',array('bannerId' => $bannerId,'brandId' => $brandId));
        // $bannerId = $this->banner->insert_banner();
        // redirect("backend/brand/banner/edit/" . $bannerId);
    }

    public function edit($bannerId = false)
    {
        if (!$row = $this->banner->get_brand_banner_by_id($bannerId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/brand/banner');
        endif;

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->banner->update_brand_banner($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/brand/banner/index/'.$row->brandId . $this->query);
                endif;
            endif;

            redirect('backend/brand/banner/edit/' . $bannerId . $this->query);
        endif;

        $data = array(
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($bannerId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->banner->get_brand_banner_by_id($bannerId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $brandId = $row->brandId;
            $this->banner->delete_brand_banner($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/brand/banner/index/'.$brandId . $this->query);
    }

    public function save($brandId)
    {
        if ($order = $this->input->post('bannerOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_brand_banner', $order, 'bannerId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/brand/banner/index/'.$brandId.$this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/brand/banner/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}