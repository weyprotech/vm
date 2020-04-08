<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_admin_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this);
    }

    public function get_group_select($filter = false, $order = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $query = $this->db->where('group.is_enable', 1)->get('tb_admin_group as group');
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }

    public function count_group($filter = false)
    {
        $this->set_filter($filter);
        return $this->db->where('group.is_enable', 1)->count_all_results('tb_admin_group as group');
    }

    public function get_group_by_id($groupId, $boolean = array('enable' => true))
    {
        $this->set_filter(array(array('field' => 'group.is_enable', 'value' => $boolean['enable'])));
        $query = $this->db->where('group.groupId', $groupId)->get('tb_admin_group as group');
        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return false;
    }

    public function insert_group()
    {
        $data = $this->check_db_data(array(
            'order' => $this->count_group() + 1
        ));

        $this->insert('tb_admin_group', $data);
        return $this->db->insert_id();
    }

    public function update_group($group, $post)
    {
        $update = $this->check_db_data($post);

        $this->update('tb_admin_group', $update, array('groupId' => $group->groupId));
        return true;
    }

    public function delete_group($group)
    {
        $this->delete('tb_admin_group', $this->check_db_data(array('is_enable' => 0)), array('groupId' => $group->groupId));
        return $this->reorder_group();
    }

    /**
     * 重新排序
     */
    private function reorder_group()
    {
        $result = $this->get_group_select(false, array(array('field' => 'group.order', 'dir' => 'asc')));
        if ($result) {
            foreach ($result as $i => $row) {
                $order[] = $this->check_db_data(array('groupId' => $row->groupId, 'order' => $i + 1));
            }
            return $this->db->update_batch('tb_admin_group', $order, 'groupId');
        }

        return true;
    }

    public function get_user_select($filter = false, $order = false, $limit = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->setUserJoin();
        $query = $this->db->where('user.is_enable', 1)->get('tb_admin_user as user');
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }

    public function count_user($filter = false)
    {
        $this->set_filter($filter);
        $this->setUserJoin();
        return $this->db->where('user.is_enable', 1)->count_all_results('tb_admin_user as user');
    }

    public function get_user_by_id($userId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_filter(array(array('field' => 'user.is_enable', 'value' => $boolean['enable']), array('field' => 'user.is_visible', 'value' => $boolean['visible'])));
        $this->setUserJoin($boolean['enable'] ? 'inner' : 'left');
        $query = $this->db->where('user.userId', $userId)->get('tb_admin_user as user');
        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return false;
    }

    public function check_user($account, $password)
    {
        $query = $this->db->where('account', $account)->where('password', md5($password))->where('is_enable', 1)->where('is_visible',1)->get('tb_admin_user');

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function insert_user()
    {
        $data = $this->check_db_data(array('auth' => array()));

        $this->insert('tb_admin_user', $data);
        return $this->db->insert_id();
    }

    public function update_user($user, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($update['account'])) {
            $filter = array(
                array('field' => 'user.userId <>', 'value' => $user->userId),
                array('field' => 'user.account', 'value' => $update['account']),
                array('field' => 'user.password', 'value' => isset($update['password']) ? $update['password'] : $user->password)
            );

            if ($this->get_user_select($filter)) {
                return false;
            }
        }

        $this->update('tb_admin_user', $update, array('userId' => $user->userId));
        return true;
    }

    public function delete_user($user)
    {
        $this->delete('tb_admin_user', $this->check_db_data(array('is_enable' => 0)), array('userId' => $user->userId));
        return true;
    }

    /******************** Private Function ********************/
    /**
     * Set User Join
     */
    private function setUserJoin($join = 'inner')
    {
        $this->db->select('user.*');
        // $this->db->select('group.name as groupName, group.order as groupOrder');
        // $this->db->join('tb_admin_group as group', 'group.groupId = user.gId', $join);
    }

    /**
     * 處理資料
     */
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value) {
            if (!in_array($field, array('uuid'))) {
                switch ($field) {
                    case 'auth' :
                        $data[$field] = check_input_value(json_encode($value));
                        break;

                    case 'password' :
                        if ($value = check_input_value($value)) {
                            $data[$field] = md5($value);
                        }
                        break;

                    default :
                        $int_array = array(
                            'is_enable', 'is_visible', 'order', /* Common Field */
                            'adminId', 'gId', /* User Field */
                            'groupId' /* Group Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                }
            }
        }

        return $data;
    }
    /******************** End Private Function ********************/
}