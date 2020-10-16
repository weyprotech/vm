<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_manufacturer_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('manufacturer/'); // 上傳路徑
    }

    /******************** manufacturer Model ********************/
    public function get_manufacturer_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_manufacturer_join($langId);
        $query = $this->db->where('manufacturer.is_enable', 1)->get('tb_manufacturer as manufacturer');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_manufacturer($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_manufacturer_join($langId);
        return $this->db->where('manufacturer.is_enable', 1)->count_all_results('tb_manufacturer as manufacturer');
    }

    public function get_manufacturer_by_id($manufacturerId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_manufacturer_join($langId);
        $this->set_filter(array(array('field' => 'manufacturer.is_enable', 'value' => $boolean['enable']), array('field' => 'manufacturer.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('manufacturer.manufacturerId', $manufacturerId)->get('tb_manufacturer as manufacturer');

        if ($query->num_rows() > 0):
            $manufacturer = $query->row();
            if (!$langId):
                $manufacturer->langList = $this->get_manufacturer_lang_select(array(array('field' => 'manufacturerId', 'value' => $manufacturer->manufacturerId)));
            endif;

            return $manufacturer;
        endif;

        return false;
    }

    public function insert_manufacturer($post)
    {
        $post['create_at'] =  date("Y-m-d H:i:s");
        $post['is_enable'] = 1;
        $post['is_visible'] = 1;
        $insert = $this->check_db_data($post);
        $insert = $this->check_db_data($post);
        
        if (isset($_FILES['firstbannerImg']) && !$_FILES['firstbannerImg']['error']){
            $insert['firstbannerImg'] = $this->uploadFile('firstbanner', $post['manufacturerId']  . '/', 1920);
        }

        if (isset($_FILES['iconImg']) && !$_FILES['iconImg']['error']){
            $insert['iconImg'] = $this->uploadFile('icon', $post['manufacturerId']  . '/', 100);
        }

        if (isset($_FILES['content1Img']) && !$_FILES['content1Img']['error']){
            $insert['content1Img'] = $this->uploadFile('content1', $post['manufacturerId']  . '/', 380);
        }

        if (isset($_FILES['content2Img']) && !$_FILES['content2Img']['error']){
            $insert['content2Img'] = $this->uploadFile('content2', $post['manufacturerId']  . '/', 380);
        }

        if (isset($_FILES['secondbannerImg']) && !$_FILES['secondbannerImg']['error']){
            $insert['secondbannerImg'] = $this->uploadFile('secondbanner', $post['manufacturerId']  . '/', 1920);
        }
            
        if (isset($_FILES['popup1Img']) && !$_FILES['popup1Img']['error']){
            $insert['popup1Img'] = $this->uploadFile('popup1', $post['manufacturerId']  . '/', 936);
        }            

        if (isset($_FILES['popup2Img']) && !$_FILES['popup2Img']['error']){
            $insert['popup2Img'] = $this->uploadFile('popup2', $post['manufacturerId']  . '/', 936);
        }

        if (isset($_FILES['popup3Img']) && !$_FILES['popup3Img']['error']){
            $insert['popup3Img'] = $this->uploadFile('popup3', $post['manufacturerId']  . '/', 936);
        }

        if (isset($post['langList'])){
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;
            $this->update_manufacturer_lang($post['manufacturerId'], $post['langList']);
        }

        $this->insert('tb_manufacturer', $insert);
        return $this->db->insert_id();
    }

    public function update_manufacturer($manufacturer, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($_FILES['firstbannerImg']) && !$_FILES['firstbannerImg']['error']):
            $update['firstbannerImg'] = $this->uploadFile('firstbanner', $manufacturer->manufacturerId  . '/', 1920);
        endif;

        if (isset($_FILES['iconImg']) && !$_FILES['iconImg']['error']):
            $update['iconImg'] = $this->uploadFile('icon', $manufacturer->manufacturerId  . '/', 100);
        endif;

        if (isset($_FILES['content1Img']) && !$_FILES['content1Img']['error']):
            $update['content1Img'] = $this->uploadFile('content1', $manufacturer->manufacturerId  . '/', 380);
        endif;

        if (isset($_FILES['content2Img']) && !$_FILES['content2Img']['error']):
            $update['content2Img'] = $this->uploadFile('content2', $manufacturer->manufacturerId  . '/', 380);
        endif;

        if (isset($_FILES['secondbannerImg']) && !$_FILES['secondbannerImg']['error']):
            $update['secondbannerImg'] = $this->uploadFile('secondbanner', $manufacturer->manufacturerId  . '/', 1920);
        endif;

        if (isset($_FILES['popup1Img']) && !$_FILES['popup1Img']['error']):
            $update['popup1Img'] = $this->uploadFile('popup1', $manufacturer->manufacturerId . '/', 936);
        endif;

        if (isset($_FILES['popup2Img']) && !$_FILES['popup2Img']['error']):
            $update['popup2Img'] = $this->uploadFile('popup2', $manufacturer->manufacturerId  . '/', 936);
        endif;

        if (isset($_FILES['popup3Img']) && !$_FILES['popup3Img']['error']):
            $update['popup3Img'] = $this->uploadFile('popup3', $manufacturer->manufacturerId  . '/', 936);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_manufacturer_lang($manufacturer->manufacturerId, $post['langList']);
        endif;

        $this->update('tb_manufacturer', $update, array('manufacturerId' => $manufacturer->manufacturerId));
        return true;
    }

    public function delete_manufacturer($manufacturer)
    {
        $this->delete('tb_manufacturer', $this->check_db_data(array('is_enable' => 0)), array('manufacturerId' => $manufacturer->manufacturerId));
        return true;
    }

    /*************** manufacturer Lang Model ***************/
    private function get_manufacturer_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_manufacturer_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_manufacturer_lang($manufacturerId, $update)
    {
        $this->db->where('manufacturerId', $manufacturerId)->update_batch('tb_manufacturer_lang', $update, 'langId');
      
        $langList = $this->get_manufacturer_lang_select(array(array('field' => 'manufacturerId', 'value' => $manufacturerId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_manufacturer_lang', $insert);
        endif;

        return true;
    }
    /*************** End manufacturer Lang Model ***************/
    /******************** End manufacturer Model ********************/

    /******************** Private Function ********************/
    private function set_manufacturer_join($langId)
    {
        $this->db->select('manufacturer.*');
        if ($langId):
            $this->db->select('lang.*');
            $this->db->join('tb_manufacturer_lang as lang', 'lang.manufacturerId = manufacturer.manufacturerId AND lang.langId = ' . $langId);
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
                            'designerId', 'cId' /* manufacturer Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}