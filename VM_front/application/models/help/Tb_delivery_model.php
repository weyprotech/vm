<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_delivery_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('delivery'); // 上傳路徑
    }

    /******************** sale Model ********************/
    /******************** start delivery_information **************/
    public function get_delivery_information($langId = false){
        if($langId){
            $this->db->select('delivery_information.*,lang.*');
            $this->db->join('tb_delivery_information_lang as lang','lang.iId = delivery_information.Id AND lang.langId = '.$langId,'left');
        }

        $query = $this->db->where('delivery_information.Id',1)->get('tb_delivery_information as delivery_information');
    
        if($query->num_rows() > 0){
            $delivery_information = $query->row();
            if (!$langId):
                $delivery_information->langList = $this->get_delivery_information_lang(array(array('field' => 'iId', 'value' => $delivery_information->Id)));
            endif;

            return $delivery_information;
        }
        return false;
    }

    public function update_delivery_information($post){
        $update = $this->check_db_data($post);
        if (isset($_FILES['informationImg']) && !$_FILES['informationImg']['error']):
            $update['informationImg'] = $this->uploadFile('information', 'information' . '/', 631);
        endif;
        $this->update_delivery_information_lang($post['langList']);
        $this->db->update('tb_delivery_information',$update,array('Id' => 1));
        return true;
    }

    /*************** delivery_information Lang Model ***************/
    private function get_delivery_information_lang($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_delivery_information_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;
        return $langList;
    }

    private function update_delivery_information_lang($update)
    {
        $this->db->where('iId', 1)->update_batch('tb_delivery_information_lang', $update, 'langId');

        $langList = $this->get_delivery_information_lang(array(array('field' => 'iId', 'value' => 1)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_delivery_information_lang', $insert);
        endif;

        return true;
    }

    /********************* end delivery_information *****************/
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

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'saleId', 'cId', 'pId', /* sale Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** 處理資料 ********************/
}