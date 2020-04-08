<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Runway extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('designer/tb_runway_model', 'runway_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index($designerId = false)
    {
        if(!$runway = $this->runway_model->get_runway_select(array(array('field' => 'runway.designerId','value' => $designerId)),false,false,$this->langId)){
            $runway = array();
            $runwayId = uniqid();
        }else{
            $runwayId = $runway[0]->runwayId;
        }
        
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if(empty($runway)){
                unset($post['dt_basic_length']);
                $post['designerId'] = $designerId;
                $this->runway_model->insert_runway($post);
            }else{
                if ($runway[0]->uuid != $post['uuid']):
                    $this->set_active_status('danger', 'Date has been changed');
                else:
                    unset($post['dt_basic_length']);
                    $post['designerId'] = $designerId;

                    $this->runway_model->update_runway($runway[0], $post);
                
                    $this->set_active_status('success', 'Success');

                    if ($this->input->get('back', true)):
                        redirect('backend/designer/designer/index/'.$designerId . $this->query);
                    endif;
                endif;
            }            

            redirect('backend/designer/runway/index/' . $designerId . $this->query);
        endif;

        $data = array(
            'runwayId' => $runwayId,
            'runway' => $runway,
            'designerId' => $designerId
        );
        if(!empty($runway)){
            $this->get_view('edit', $data);
        }else{
            $this->get_view('add', $data);            
        }
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/designer/runway/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}