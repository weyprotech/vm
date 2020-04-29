<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Backend_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()) {
            redirect('admin');
        }
    }

    public function index()
    {
        if (!$this->check_action_auth($this->prevId, 'view')) {
            return $this->load->view('backend/index', $this->get_page_nav(), false);
        }

        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('user/index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth

        $userId = $this->admin->insert_user();
        redirect('backend/admin/edit/' . $userId);
    }

    public function edit($userId)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        if (!$row = $this->admin->get_user_by_id($userId, array('enable' => false, 'visible' => false))) {
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/admin');
        }

        if ($post = $this->input->post(null, true)) {
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']) {
                $this->set_active_status('danger', 'Date has been changed');
            }
            else {
                if ($this->admin->update_user($row, $post)) {
                    $this->set_active_status('success', 'Success');
                }
                else {
                    $this->set_active_status('danger', 'This account and password have been used');
                }

                if ($this->input->get('back', true)) {
                    redirect('backend/admin');
                }
            }

            redirect('backend/admin/edit/' . $userId);
        }

        $data = array(
            'row' => $row,
            'groupList' => $this->admin->get_group_select(false, array(array('field' => 'group.order', 'dir' => 'asc'))),
            'authList' => $this->load->view('backend/admin/_menuList', array('menuId' => 0, 'menuList' => $this->menuList, 'auth' => !empty($row->auth) ? json_decode($row->auth, true) : false), true)
        );

        $this->get_view('user/edit', $data);
    }

    public function delete($userId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->admin->get_user_by_id($userId, array('enable' => true, 'visible' => false))) {
            $this->set_active_status('danger', 'The data does not exist!');
        }
        else {
            $this->admin->delete_user($row);
            $this->set_active_status('success', 'Success');
        }

        redirect('backend/admin');
    }

    // public function insert_data(){
    //     $json_string = file_get_contents('assets/stores.json');
    //     $data = json_decode($json_string, true); 

    //     foreach ($data as $dataKey => $dataValue){
    //         switch ($dataValue['streetName']){
    //             case 'Versailles Avenue':
    //                 $streeId = 1;
    //                 break;
    //             case 'Berlin Lane':
    //                 $streeId = 2;
    //                 break;
    //             case 'Victoria Lane':
    //                 $streeId = 3;
    //                 break;
    //             case 'Bond Street':
    //                 $streeId = 4;
    //                 break;
    //             case 'Barcelona Street':
    //                 $streeId = 5;
    //                 break;
    //             case 'Prague Alley':
    //                 $streeId = 6;
    //                 break;
    //             case 'Maiden Lane':
    //                 $streeId = 7;
    //                 break;
    //             case 'Via Milano':
    //                 $streeId = 8;
    //                 break;
    //             case 'Hyde Park Street':
    //                 $streeId = 9;
    //                 break;
    //             case 'London Walk':
    //                 $streeId = 10;
    //                 break;
    //             case 'Da Vinci Road':
    //                 $streeId = 11;
    //                 break;
    //             case 'Paris Boulevard':
    //                 $streeId = 12;
    //                 break;
    //             case 'Michaelangelo Lane':
    //                 $streeId = 13;
    //                 break;
    //             case 'Piccadilly Way':
    //                 $streeId = 14;
    //                 break;
    //             case 'Acropolis Way':
    //                 $streeId = 15;
    //                 break;
    //             case 'Palermo Street':
    //                 $streeId = 16;
    //                 break;
    //         }
    //         foreach($dataValue['stores'] as $storeKey => $storeValue){
    //             $this->db->insert('tb_location', array('streeId' => $streeId,'number' => $storeValue['number'],'location_x' => $storeValue['latlng'][0],'location_y' => $storeValue['latlng'][1]));                
    //         }
    //     }
    // }

    /******************** Group Function ********************/
    public function group($action = 'view', $groupId = false)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        switch ($action) {
            case 'add' :
                $this->check_action_auth($this->menuId, 'add', true); // Check Auth

                $groupId = $this->admin->insert_group();
                redirect('backend/admin/group/edit/' . $groupId);
                break;
            case 'edit' :
                if (!$row = $this->admin->get_group_by_id($groupId, array('enable' => false))) {
                    $this->set_active_status('danger', 'The data does not exist!');
                    redirect('backend/admin/group');
                }

                if ($post = $this->input->post(null, true)) {
                    $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

                    if ($row->uuid != $post['uuid']) {
                        $this->set_active_status('danger', 'Date has been changed');
                    }
                    else {
                        $this->admin->update_group($row, $post);
                        $this->set_active_status('success', 'Success');

                        if ($this->input->get('back', true)) {
                            redirect('backend/admin/group');
                        }
                    }

                    redirect('backend/admin/group/edit/' . $groupId);
                }

                $data = array(
                    'row' => $row,
                    'authList' => $this->load->view('backend/admin/_menuList', array('menuId' => 0, 'menuList' => $this->menuList, 'auth' => !empty($row->auth) ? json_decode($row->auth, true) : false), true)
                );
                break;
            case 'delete' :
                $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

                if (!$row = $this->admin->get_group_by_id($groupId)) {
                    $this->set_active_status('danger', 'The data does not exist!');
                }
                else {
                    $this->admin->delete_group($row);
                    $this->set_active_status('success', 'Success');
                }

                redirect('backend/admin/group');
                break;
            case 'save' :
                if ($order = $this->input->post('groupOrder', true)) {
                    $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

                    foreach ($order as $i => $row) {
                        $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
                    }

                    $this->db->update_batch('tb_admin_group', $order, 'groupId');
                    $this->set_active_status('success', 'Success');
                }

                redirect('backend/admin/group');
                break;
            default :
                $action = 'index';
                $data = array(
                    'groupList' => $this->admin->get_group_select(false, array(array('field' => 'group.order', 'dir' => 'asc')))
                );
        }

        $this->get_view('group/' . $action, $data);
    }
    /******************** End Group Function ********************/

    /******************** Public Function ********************/
    public function get_group_auth()
    {
        if ($this->check_action_auth($this->menuId, 'edit')) {// Check Auth
            $groupId = $this->input->post('groupId', true);
            $group = $this->admin->get_group_by_id($groupId);

            echo $this->load->view('backend/admin/_menuList', array('menuId' => 0, 'menuList' => $this->menuList, 'auth' => ($group && !empty($group->auth)) ? json_decode($group->auth, true) : false), true);
        }
    }
    /******************** End Public Function ********************/

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/admin/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
    /******************** End Private Function ********************/
}