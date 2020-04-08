<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_topdesigner_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('designer/designer/'); // 上傳路徑
    }

    /******************** designer Model ********************/
    public function get_topdesigner_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_topdesigner_join($langId);
        $query = $this->db->get('tb_designer_top as designer_top');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function update_topdesigner($post)
    {
        $this->db->update_batch('tb_designer_top', $post,'Id');
        return true;
    }

    public function delete_designer($designer)
    {
        $this->delete('tb_designer', $this->check_db_data(array('is_enable' => 0)), array('designerId' => $designer->designerId));
        return $this->reorder_designer();
    }

    /*************** 重新排序 ***************/
    private function reorder_designer()
    {
        $result = $this->get_designer_select(false, array(array('field' => 'designer.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('designerId' => $row->designerId, 'order' => $i + 1));
            endforeach;
            return $this->db->update_batch('tb_designer', $order, 'designerId');
        endif;

        return true;
    }

    /*************** designer Lang Model ***************/
    private function get_designer_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_designer_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_designer_lang($designerId, $update)
    {
        $this->db->where('designerId', $designerId)->update_batch('tb_designer_lang', $update, 'langId');
      
        $langList = $this->get_designer_lang_select(array(array('field' => 'designerId', 'value' => $designerId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_designer_lang', $insert);
        endif;

        return true;
    }
    /*************** End designer Lang Model ***************/
    /******************** End designer Model ********************/

    /******************** Private Function ********************/
    private function set_topdesigner_join($langId)
    {
        $this->db->select('designer_top.*,designer.*');
        $this->db->join('tb_designer as designer','designer.designerId = designer_top.designerId','inner');
        if ($langId):
            $this->db->select('lang.name');
            $this->db->join('tb_designer_lang as lang', 'lang.designerId = designer.designerId AND lang.langId = ' . $langId);
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
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'designerId', 'cId' /* designer Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}