<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_company_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('company'); // 上傳路徑
    }

    /******************** sale Model ********************/
    /******************** start company_information **************/
    public function get_company_information($langId = false){
        if($langId):
            $this->db->select('company_information.*,lang.about, lang.store,lang.policy,lang.cooperation');
            $this->db->join('tb_company_information_lang as lang','lang.iId = company_information.Id AND lang.langId = '.$langId,'left');
        endif;
        $query = $this->db->where('company_information.Id',1)->get('tb_company_information as company_information');

        if($query->num_rows() > 0){
            $company_information = $query->row();
            if (!$langId):
                $company_information->langList = $this->get_company_information_lang(array(array('field' => 'iId', 'value' => $company_information->Id)));
            endif;

            return $company_information;
        }
        return false;
    }

    public function update_company_information($post){
        $update = $this->check_db_data($post);
        if (isset($_FILES['informationImg']) && !$_FILES['informationImg']['error']):
            $update['informationImg'] = $this->uploadFile('information', 'information' . '/', 631);
        endif;
        $this->update_company_information_lang($post['langList']);
        $this->db->update('tb_company_information',$update,array('Id' => 1));
        return true;
    }

    /*************** company_information Lang Model ***************/
    private function get_company_information_lang($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_company_information_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;
        return $langList;
    }

    private function update_company_information_lang($update)
    {
        $this->db->where('iId', 1)->update_batch('tb_company_information_lang', $update, 'langId');

        $langList = $this->get_company_information_lang(array(array('field' => 'iId', 'value' => 1)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_company_information_lang', $insert);
        endif;

        return true;
    }

    /********************* end company_information *****************/
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