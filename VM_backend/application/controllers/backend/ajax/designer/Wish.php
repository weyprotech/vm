<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wish extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('designer/tb_wish_model', 'wish');
        $this->load->model('member/tb_member_model', 'member');
    }

    /******************** wish ********************/
    public function get_wish_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $designerId = $this->input->get('designerId', true);
        $query = $this->set_http_query(array('designerId' => $designerId));

        /***** Order *****/
        $order = array(array('field' => 'wish.create_at', 'dir' => 'desc'));

        $wishList = $this->wish->get_wish_select(array(array('field' => 'wish.designerId','value' => $designerId)), $order, array('limit' => $limit, 'start' => $start), 3);
        $recordsTotal = $this->wish->count_wish(array(array('field' => 'wish.designerId','value' => $designerId)), 3);
        if ($wishList):
            foreach ($wishList as $row):
                $member = $this->member->get_member_by_id($row->memberId);
                $data[] = array(     
                    'name' => $member->first_name . " " . $member->last_name,
                    'title' => $row->title,
                    'content' => $row->content,
                    'action' => '<a class="btn btn-success" href="'.site_url('backend/designer/wish/view/'.$row->Id).'"><i class="fa fa-eye"></i><span class="hidden-mobile"> View</span></a>'
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    /******************** End message ********************/
}