<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_fabric_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('fabric/'); // 上傳路徑
    }

    /******************** fabric Model ********************/
    public function get_fabric_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_fabric_join($langId);
        $query = $this->db->where('fabric.is_enable', 1)->get('tb_fabric as fabric');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_fabric($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_fabric_join($langId);
        return $this->db->where('fabric.is_enable', 1)->count_all_results('tb_fabric as fabric');
    }

    public function get_fabric_by_id($fabricId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_fabric_join($langId);
        $this->set_filter(array(array('field' => 'fabric.is_enable', 'value' => $boolean['enable']), array('field' => 'fabric.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('fabric.fabricId', $fabricId)->get('tb_fabric as fabric');

        if ($query->num_rows() > 0):
            $fabric = $query->row();
            if (!$langId):
                $fabric->langList = $this->get_fabric_lang_select(array(array('field' => 'fabricId', 'value' => $fabric->fabricId)));
            endif;

            return $fabric;
        endif;

        return false;
    }

    public function insert_fabric($post)
    {
        $post['create_at'] =  date("Y-m-d H:i:s");
        $post['is_enable'] = 1;
        $post['is_visible'] = 1;
        $insert = $this->check_db_data($post);

        if (isset($_FILES['firstbannerImg']) && !$_FILES['firstbannerImg']['error']){
            $insert['firstbannerImg'] = $this->uploadFile('firstbanner', $post['manufacturerId']  . '/', 1920);
        }

        if (isset($_FILES['iconImg']) && !$_FILES['iconImg']['error']){
            $insert['iconImg'] = $this->uploadFile('icon', $post['fabricId']  . '/', 100);
        }

        if (isset($_FILES['content1Img']) && !$_FILES['content1Img']['error']){
            $insert['content1Img'] = $this->uploadFile('content1', $post['fabricId']  . '/', 380);
        }

        if (isset($_FILES['content2Img']) && !$_FILES['content2Img']['error']){
            $insert['content2Img'] = $this->uploadFile('content2', $post['fabricId']  . '/', 380);
        }

        if (isset($_FILES['secondbannerImg']) && !$_FILES['secondbannerImg']['error']){
            $insert['secondbannerImg'] = $this->uploadFile('secondbanner', $post['fabricId']  . '/', 1920);
        }
            
        if (isset($_FILES['popup1Img']) && !$_FILES['popup1Img']['error']){
            $insert['popup1Img'] = $this->uploadFile('popup1', $post['fabricId']  . '/', 936);
        }            

        if (isset($_FILES['popup2Img']) && !$_FILES['popup2Img']['error']){
            $insert['popup2Img'] = $this->uploadFile('popup2', $post['fabricId']  . '/', 936);
        }

        if (isset($_FILES['popup3Img']) && !$_FILES['popup3Img']['error']){
            $insert['popup3Img'] = $this->uploadFile('popup3', $post['fabricId']  . '/', 936);
        }

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_fabric_lang($post['fabricId'], $post['langList']);
        endif;

        $this->insert('tb_fabric', $insert);
        return $this->db->insert_id();
    }

    public function update_fabric($fabric, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($_FILES['firstbannerImg']) && !$_FILES['firstbannerImg']['error']):
            $update['firstbannerImg'] = $this->uploadFile('firstbanner', $fabric->fabricId  . '/', 1920);
        endif;

        if (isset($_FILES['iconImg']) && !$_FILES['iconImg']['error']):
            $update['iconImg'] = $this->uploadFile('icon', $fabric->fabricId  . '/', 100);
        endif;

        if (isset($_FILES['content1Img']) && !$_FILES['content1Img']['error']):
            $update['content1Img'] = $this->uploadFile('content1', $fabric->fabricId  . '/', 380);
        endif;

        if (isset($_FILES['content2Img']) && !$_FILES['content2Img']['error']):
            $update['content2Img'] = $this->uploadFile('content2', $fabric->fabricId  . '/', 380);
        endif;

        if (isset($_FILES['secondbannerImg']) && !$_FILES['secondbannerImg']['error']):
            $update['secondbannerImg'] = $this->uploadFile('secondbanner', $fabric->fabricId  . '/', 1920);
        endif;

        if (isset($_FILES['popup1Img']) && !$_FILES['popup1Img']['error']):
            $update['popup1Img'] = $this->uploadFile('popup1', $fabric->fabricId . '/', 936);
        endif;

        if (isset($_FILES['popup2Img']) && !$_FILES['popup2Img']['error']):
            $update['popup2Img'] = $this->uploadFile('popup2', $fabric->fabricId  . '/', 936);
        endif;

        if (isset($_FILES['popup3Img']) && !$_FILES['popup3Img']['error']):
            $update['popup3Img'] = $this->uploadFile('popup3', $fabric->fabricId  . '/', 936);
        endif;
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_fabric_lang($fabric->fabricId, $post['langList']);
        endif;

        $this->update('tb_fabric', $update, array('fabricId' => $fabric->fabricId));
        return true;
    }

    public function delete_fabric($fabric)
    {
        $this->delete('tb_fabric', $this->check_db_data(array('is_enable' => 0)), array('fabricId' => $fabric->fabricId));
        return true;
    }

    /*************** fabric Lang Model ***************/
    private function get_fabric_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_fabric_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_fabric_lang($fabricId, $update)
    {
        $this->db->where('fabricId', $fabricId)->update_batch('tb_fabric_lang', $update, 'langId');
      
        $langList = $this->get_fabric_lang_select(array(array('field' => 'fabricId', 'value' => $fabricId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_fabric_lang', $insert);
        endif;

        return true;
    }
    /*************** End fabric Lang Model ***************/
    /******************** End fabric Model ********************/

    /******************** Private Function ********************/
    private function set_fabric_join($langId)
    {
        $this->db->select('fabric.*');
        if ($langId):
            $this->db->select('lang.*');
            $this->db->join('tb_fabric_lang as lang', 'lang.fabricId = fabric.fabricId AND lang.langId = ' . $langId);
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
                            'designerId', 'cId' /* fabric Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}