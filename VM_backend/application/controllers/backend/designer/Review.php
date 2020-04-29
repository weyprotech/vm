<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Review extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('product/tb_review_model', 'review_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index($designerId)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index',array('designerId' => $designerId));
    }

    public function add($designerId)
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $reviewId = uniqid();

        if($review = $this->input->review(null,true)){
            $review['designerId'] = $designerId;
            $reviewId = $review['reviewId'];
            unset($review['dt_basic_length']);

            $this->review_model->insert_review($review);
            if($this->input->get('back',true)){
                redirect("backend/designer/review/index/".$designerId);
            }
            redirect('backend/designer/review/edit/' . $reviewId . $this->query);
        }
        $this->get_view('add',array('reviewId' => $reviewId,'designerId' => $designerId));
    }

    public function edit($reviewId = false)
    {

        if (!$row = $this->review_model->get_review_by_id($reviewId, 3, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/review');
        endif;

        if ($review = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $review['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                unset($review['dt_basic_length']);
                $this->review_model->update_review($row, $review);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/designer/review/index/'.$row->designerId . $this->query);
                endif;
            endif;
            redirect('backend/designer/review/edit/' . $reviewId . $this->query);
        endif;

        $data = array(
            'row' => $row,
            'reviewId' => $reviewId,
            'designerId' => $row->designerId
        );

        $this->get_view('edit', $data);
    }

    public function delete($reviewId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->review_model->get_review_by_id($reviewId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $designerId = $row->designerId;
            $this->review_model->delete_review($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/designer/review/index/'.$designerId . $this->query);
    }

    public function save($designerId)
    {
        if ($order = $this->input->review('reviewOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_designer_review', $order, 'reviewId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/designer/review/index/'.$designerId . $this->query);
    }
    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/designer/review/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}