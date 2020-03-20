<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_events_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('events/events/'); // 上傳路徑
    }

    /******************** events Model ********************/
    public function get_events_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_events_join($langId);
        $query = $this->db->where('events.is_enable', 1)->get('tb_events as events');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_events($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_events_join($langId);
        return $this->db->where('events.is_enable', 1)->count_all_results('tb_events as events');
    }

    public function get_events_by_id($eventsId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_events_join($langId);
        $this->set_filter(array(array('field' => 'events.is_enable', 'value' => $boolean['enable']), array('field' => 'events.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('events.eventsId', $eventsId)->get('tb_events as events');

        if ($query->num_rows() > 0):
            $events = $query->row();
            if (!$langId):
                $events->langList = $this->get_events_lang_select(array(array('field' => 'eventsId', 'value' => $events->eventsId)));
            endif;

            return $events;
        endif;

        return false;
    }

    public function insert_events($post)
    {
        $post['order'] = $this->count_events() + 1;
        $post['create_at'] =  date("Y-m-d H:i:s");
        $post['is_enable'] = 1;
        $post['is_visible'] = 1;
        $insert = $this->check_db_data($post);
        if (isset($_FILES['eventsiconImg']) && !$_FILES['eventsiconImg']['error']):
            $insert['eventsiconImg'] = $this->uploadFile('eventsicon', $post['eventsId'] . '/', 100);
        endif;
        if (isset($_FILES['eventsImg']) && !$_FILES['eventsImg']['error']):
            $insert['eventsImg'] = $this->uploadFile('events',  $post['eventsId'] . '/', 600);
        endif;
        if (isset($_FILES['eventsindexImg']) && !$_FILES['eventsindexImg']['error']):
            $insert['eventsindexImg'] = $this->uploadFile('eventsindex',  $post['eventsId'] . '/', 360);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_events_lang($post['eventsId'], $post['langList']);
        endif;

        $this->insert('tb_events', $insert);
        return $this->db->insert_id();
    }

    public function update_events($events, $post)
    {
        $update = $this->check_db_data($post);
        if (isset($_FILES['eventsiconImg']) && !$_FILES['eventsiconImg']['error']):
            $update['eventsiconImg'] = $this->uploadFile('eventsicon', $events->eventsId . '/', 100);
        endif;
        if (isset($_FILES['eventsImg']) && !$_FILES['eventsImg']['error']):
            $update['eventsImg'] = $this->uploadFile('events', $events->eventsId . '/', 600);
        endif;
        if (isset($_FILES['eventsindexImg']) && !$_FILES['eventsindexImg']['error']):
            $update['eventsindexImg'] = $this->uploadFile('eventsindex', $events->eventsId . '/', 360);
        endif;        
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_events_lang($events->eventsId, $post['langList']);
        endif;

        $this->update('tb_events', $update, array('eventsId' => $events->eventsId));
        return true;
    }

    public function delete_events($events)
    {
        $this->delete('tb_events', $this->check_db_data(array('is_enable' => 0)), array('eventsId' => $events->eventsId));
        return $this->reorder_events();
    }

    /*************** 重新排序 ***************/
    private function reorder_events()
    {
        $result = $this->get_events_select(false, array(array('field' => 'events.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('eventsId' => $row->eventsId, 'order' => $i + 1));
            endforeach;
            return $this->db->update_batch('tb_events', $order, 'eventsId');
        endif;

        return true;
    }

    /*************** events Lang Model ***************/
    private function get_events_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_events_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_events_lang($eventsId, $update)
    {
        $this->db->where('eventsId', $eventsId)->update_batch('tb_events_lang', $update, 'langId');
      
        $langList = $this->get_events_lang_select(array(array('field' => 'eventsId', 'value' => $eventsId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_events_lang', $insert);
        endif;

        return true;
    }
    /*************** End events Lang Model ***************/
    /******************** End events Model ********************/

    /******************** Private Function ********************/
    private function set_events_join($langId)
    {
        $this->db->select('events.*');
        if ($langId):
            $this->db->select('lang.name');
            $this->db->join('tb_events_lang as lang', 'lang.eventId = events.eventId AND lang.langId = ' . $langId);
        endif;
        return true;
    }

    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    case 'detail':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'designerId', 'cId' /* events Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}