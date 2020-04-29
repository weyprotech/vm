<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Review extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('product/tb_review_model', 'review');
        $this->load->model('brand/tb_brand_model','brand');
    }

    /******************** review ********************/
    public function get_review_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $designerId = $this->input->get('designerId', true);
        $query = $this->set_http_query(array('designerId' => $designerId));

        /***** Order *****/
        $order = array(array('field' => 'review.create_at', 'dir' => 'desc'));

        $reviewList = $this->review->get_review_select(array(array('field' => 'review.designerId','value' => $designerId)), $order, array('limit' => $limit, 'start' => $start), 3);
        $recordsTotal = $this->review->count_review(array(array('field' => 'review.designerId','value' => $designerId)), 3);
        if ($reviewList):
            foreach ($reviewList as $row):
                $data[] = array(     
                    'member' => $row->member_first_name.$row->member_last_name,
                    'product' => $row->product_name,
                    'review' => nl2br($row->review),
                    'score' => $row->score,
                    'action' => '<a class="btn btn-success" href="'.site_url('backend/designer/review/edit/'.$row->Id).'"><i class="fa fa-book"></i><span class="hidden-mobile"> Response</span></a>' . '&nbsp;&nbsp;' . $this->get_button('delete', 'backend/designer/review/delete/' . $row->Id . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    /******************** End review ********************/
}