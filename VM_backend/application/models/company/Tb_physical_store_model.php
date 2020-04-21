<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_physical_store_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('physical_store/physical_store/'); // 上傳路徑
    }

    /******************** physical_store Model ********************/
    public function get_physical_store_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_physical_store_join($langId);
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('physical_store.is_enable', 1)->get('tb_physical_store as physical_store');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_physical_store($filter = false, $langId = false)
    {
        $this->set_physical_store_join($langId);
        $this->set_filter($filter);
        return $this->db->where('physical_store.is_enable', 1)->count_all_results('tb_physical_store as physical_store');
    }

    public function get_physical_store_by_id($physical_storeId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_physical_store_join($langId);
        $this->set_filter(array(array('field' => 'physical_store.is_enable', 'value' => $boolean['enable']), array('field' => 'physical_store.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('physical_store.physical_storeId', $physical_storeId)->get('tb_physical_store as physical_store');

        if ($query->num_rows() > 0):
            $physical_store = $query->row();
            if (!$langId):
                $physical_store->langList = $this->get_physical_store_lang_select(array(array('field' => 'pId', 'value' => $physical_store->physical_storeId)));
            endif;

            return $physical_store;
        endif;

        return false;
    }

    public function insert_physical_store($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $insert = $this->check_db_data($post);
        if (isset($_FILES['physical_storeImg']) && !$_FILES['physical_storeImg']['error']):
            $insert['physical_storeImg'] = $this->uploadFile('physical_store', $post['physical_storeId'] . '/', 300);
        endif;
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_physical_store_lang($post['physical_storeId'], $post['langList']);
        endif;

        $this->db->insert('tb_physical_store', $insert);
        return true;
    }

    public function update_physical_store($physical_store, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($_FILES['physical_storeImg']) && !$_FILES['physical_storeImg']['error']):
            $update['physical_storeImg'] = $this->uploadFile('physical_store', $physical_store->physical_storeId . '/', 300);
            @unlink($physical_store->physical_storeImg);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_physical_store_lang($physical_store->physical_storeId, $post['langList']);
        endif;

        $this->db->update('tb_physical_store', $update, array('physical_storeId' => $physical_store->physical_storeId));
        return true;
    }

    public function delete_physical_store($physical_store)
    {
        $this->update_physical_store($physical_store, array('is_enable' => 0));
    }

    /*************** 重新排序 ***************/
    private function reorder_physical_store($cId)
    {
        $result = $this->get_physical_store_select(array(array('field' => 'physical_store.cId', 'value' => $cId)), array(array('field' => 'physical_store.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('physical_storeId' => $row->physical_storeId, 'order' => $i + 1));
            endforeach;

            return $this->db->update_batch('tb_physical_store', $order, 'physical_storeId');
        endif;

        return true;
    }

    /*************** physical_store Lang Model ***************/
    private function get_physical_store_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_physical_store_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_physical_store_lang($physical_storeId, $update)
    {
        $this->db->where('pId', $physical_storeId)->update_batch('tb_physical_store_lang', $update, 'langId');

        $langList = $this->get_physical_store_lang_select(array(array('field' => 'pId', 'value' => $physical_storeId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_physical_store_lang', $insert);
        endif;

        return true;
    }
    /*************** End physical_store Lang Model ***************/    
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('mainId', 'imageOrder', 'langList', 'uuid','size','image_list_length'))):
                switch ($field):
                    case 'minorId':
                        $data['cId'] = check_input_value($value, true);
                        break;

                    case 'detail':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;

                    case 'description':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;
                    
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'physical_storeId', 'cId', 'pId', /* physical_store Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }

    private function set_physical_store_join($langId)
    {
        $this->db->select('physical_store.*');
        if ($langId):
            $this->db->select('lang.*');
            $this->db->join('tb_physical_store_lang as lang', 'lang.pId = physical_store.physical_storeId AND lang.langId = ' . $langId, 'left');          
        endif;

        return true;
    }    
    /******************** End Private Function ********************/
}