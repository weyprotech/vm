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