<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()) {
            redirect("admin");
        }
    }

    /******************** Admin ********************/
    public function get_group_option()
    {
        $groupList = $this->admin->get_group_select(false, array(array('field' => 'group.order', 'dir' => 'asc')));
        $option = '<option value="">全部</option>';
        if ($groupList) {
            foreach ($groupList as $crow) {
                $option .= '<option value="' . $crow->groupId . '">' . $crow->name . '</option>';
            }
            $option .= '<option value="0">未選擇</option>';
        }

        echo $option;
        return TRUE;
    }

    public function get_user_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', TRUE);
        $limit = $this->input->get('length', TRUE);
        $search = $this->input->get('search[value]', TRUE);
        $filter = array('like' => array('field' => 'user.name', 'value' => $search));
        $order = array(array('field' => 'user.create_at', 'dir' => 'desc'));
        $userList = $this->admin->get_user_select($filter, $order, array('limit' => $limit, 'start' => $start));
        $recordsTotal = $this->admin->count_user($filter);
        if ($userList) {
            foreach ($userList as $urow) {
                $data[] = array(
                    'visible' => '<img src="' . show_enable_image($urow->is_visible) . '" width="25">',
                    'name' => $urow->name,
                    'action' => $this->get_button('edit', 'backend/admin/edit/' . $urow->userId) . $this->get_button('delete', 'backend/admin/delete/' . $urow->userId)
                );
            }
        }

        echo json_encode(array('draw' => $this->input->get('draw', TRUE), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return TRUE;
    }
    /******************** End Admin ********************/
}