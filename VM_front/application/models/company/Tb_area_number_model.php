<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_area_number_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('area_number/area_number/'); // 上傳路徑
    }

    /******************** area_number Model ********************/
    public function get_area_number_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        if($langId){
            $this->db->select('area_number.*,lang.area,lang.number');
            $this->db->join('tb_area_number_lang as lang','lang.aId = area_number.Id AND lang.langId ='.$langId,'left');
        }
        $query = $this->db->where('area_number.is_enable', 1)->get('tb_area_number as area_number');
        if ($query->num_rows() > 0):
            $result = $query->result();
            if(!$langId){
                foreach($result as $i => $row){
                    $result->langList = $this->get_area_number_lang_select(array(array('field' => 'tb_area_number_lang.aId','value' => $row->Id)));
                }
            }
            return $result;
            
        endif;

        return false;
    }

    public function count_area_number($filter = false,$langId = false)
    {        
        $this->set_filter($filter);
        if($langId){
            $this->db->select('area_number.*,lang.area,lang.number');
            $this->db->join('tb_area_number_lang as lang','lang.aId = area_number.Id AND lang.langId ='.$langId,'left');
        }
        return $this->db->where('area_number.is_enable', 1)->count_all_results('tb_area_number as area_number');
    }

    public function get_area_number_by_id($area_numberId = false,$langId = false)
    {        
        if($langId){
            $this->db->select('area_number.*,lang.area,lang.number');
            $this->db->join('tb_area_number_lang as lang','lang.aId = area_number.Id AND lang.langId ='.$langId,'left');
        }
        $query = $this->db->where('area_number.Id', $area_numberId)->get('tb_area_number as area_number');
        
        if ($query->num_rows() > 0):
            $area_number = $query->row();
            $area_number->langList = $this->get_area_number_lang_select(array(array('field' => 'tb_area_number_lang.aId','value' => $area_number->Id)));

            return $area_number;
        endif;

        return false;
    }

    public function insert_area_number($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $post['order'] = $this->count_area_number() + 1;

        $insert = $this->check_db_data($post);
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_area_number_lang($post['Id'], $post['langList']);
        endif;

        $this->db->insert('tb_area_number', $insert);
        return true;
    }

    public function update_area_number($area_number, $post)
    {
        $update = $this->check_db_data($post);
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_area_number_lang($area_number->Id, $post['langList']);
        endif;

        $this->db->update('tb_area_number', $update, array('Id' => $area_number->Id));
        return true;
    }

    public function delete_area_number($area_number)
    {
        $this->update_area_number($area_number, array('is_enable' => 0));
    }

    /*************** area_number Lang Model ***************/
    private function get_area_number_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_area_number_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_area_number_lang($area_numberId, $update)
    {
        $this->db->where('aId', $area_numberId)->update_batch('tb_area_number_lang', $update, 'langId');

        $langList = $this->get_area_number_lang_select(array(array('field' => 'aId', 'value' => $area_numberId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_area_number_lang', $insert);
        endif;

        return true;
    }

    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('mainId', 'imageOrder', 'langList', 'uuid','size','image_list_length'))):
                switch ($field):
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'area_numberId', 'cId', 'aId', /* area_number Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}