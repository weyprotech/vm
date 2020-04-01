<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_runway_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('designer/runway/'); // 上傳路徑

    }

    /******************** runway Model ********************/
    public function get_runway_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        if ($langId):
            $this->db->select('runway.*, lang.title, lang.content');
            $this->db->join('tb_designer_runway_lang as lang', 'lang.runwayId = runway.runwayId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('runway.is_enable', 1)->get('tb_designer_runway as runway');

        if ($query->num_rows() > 0):
            $runway = $query->result();
            foreach($query->result() as $key => $value){
                $runway[$key]->langList = $this->get_runway_lang_select(array(array('field' => 'runwayId', 'value' => $value->runwayId)));
            }

            return $runway;
        endif;

        return false;
    }

    public function count_runway($filter = false, $langId = false)
    {
        if ($langId):
            $this->db->select('runway.*, lang.title, lang.content');
            $this->db->join('tb_designer_runway_lang as lang', 'lang.runwayId = runway.runwayId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter($filter);
        return $this->db->where('runway.is_enable', 1)->count_all_results('tb_designer_runway as runway');
    }

    public function get_runway_by_id($runwayId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        if ($langId):
            $this->db->select('runway.*, lang.title, lang.content');
            $this->db->join('tb_designer_runway_lang as lang', 'lang.runwayId = runway.runwayId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter(array(array('field' => 'runway.is_enable', 'value' => $boolean['enable']), array('field' => 'runway.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('runway.runwayId', $runwayId)->get('tb_designer_runway as runway');

        if ($query->num_rows() > 0):
            $runway = $query->row();
            if (!$langId):
                $runway->langList = $this->get_runway_lang_select(array(array('field' => 'runwayId', 'value' => $runway->runwayId)));
            endif;

            return $runway;
        endif;

        return false;
    }

    public function insert_runway($post)
    {
        $insert = $this->check_db_data($post);        

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_runway_lang($post['runwayId'], $post['langList']);
        endif;
        $this->db->insert('tb_designer_runway', $insert);

        return $this->db->insert_id();
    }

    public function update_runway($runway, $update)
    {
        if (isset($update['langList'])):
            foreach ($update['langList'] as $i => $lrow):
                $update['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_runway_lang($runway->runwayId, $update['langList']);
        endif;
        $update = $this->check_db_data($update);

        $this->db->update('tb_designer_runway', $update, array('runwayId' => $runway->runwayId));
        return true;
    }

    public function delete_runway($runway)
    {
        $this->update_runway($runway, array('is_enable' => 0));
        return true;
    }

    /*************** Story Lang Model ***************/
    private function get_runway_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_designer_runway_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_runway_lang($runwayId, $update)
    {
        $this->db->where('runwayId', $runwayId)->update_batch('tb_designer_runway_lang', $update, 'langId');

        $langList = $this->get_runway_lang_select(array(array('field' => 'runwayId', 'value' => $runwayId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_designer_runway_lang', $insert);
        endif;

        return true;
    }
    /*************** End Story Lang Model ***************/
    /********** runway img Model *************/
    public function get_runway_img_select($filter = false,$order = false,$limit = false){
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->get('tb_designer_runway_img as runway_img');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function get_runway_img_by_id($id){
        $query = $this->db->where('Id',$id)->get('tb_designer_runway_img as runway_img');
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function count_runway_img($filter = false){
        $this->set_filter($filter);
        $count = $this->db->count_all_results('tb_designer_runway_img as runway_img');
        return $count;
    }

    public function insert_runway_img($runway){
        $insert = $runway;
        $insert['order'] = $this->count_runway_img() + 1;

        $this->db->insert('tb_designer_runway_img',$insert);

        return $this->db->insert_id();
    }

    public function update_runway_img_select($img,$runway){
        $update = $runway;
        $this->db->update('tb_designer_runway_img',$update,array('Id' => $img->Id));
        return true;
    }

    public function delete_runway_img($img){
        //刪除圖檔
        if(file_exists($this->uploadPath .$img->runwayImg)){
            @chmod($this->uploadPath .$img->runwayImg, 0777);
            @unlink($this->uploadPath .$img->runwayImg);
        }
        $this->db->delete('tb_designer_runway_img',array('Id' => $img->Id));

        return true;
    }
    /********* End runway img model *********/
    /********* Start runway message model *******/
    public function get_runway_message_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        if ($langId):
            $this->db->select('runway.*, lang.title, lang.content');
            $this->db->join('tb_designer_runway_lang as lang', 'lang.runwayId = runway.runwayId AND lang.langId = ' . $langId, 'left');
            $this->db->join('tb_designer_runway_message as message','message.runwayId = runway.runwayid','left');
        endif;
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('runway.is_enable', 1)->get('tb_designer_runway as runway');

        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_runway_message($filter = false, $langId = false)
    {
        if ($langId):
            $this->db->select('runway.*, lang.title, lang.content');
            $this->db->join('tb_designer_runway_lang as lang', 'lang.runwayId = runway.runwayId AND lang.langId = ' . $langId, 'left');
            $this->db->join('tb_designer_runway_message as message','message.runwayId = runway.runwayid','left');
        endif;
        $this->set_filter($filter);
        return $this->db->where('runway.is_enable', 1)->count_all_results('tb_designer_runway as runway');
    }

    public function get_runway_message_by_id($runwayId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        if ($langId):
            $this->db->select('runway.*, lang.title, lang.content');
            $this->db->join('tb_designer_runway_lang as lang', 'lang.runwayId = runway.runwayId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter(array(array('field' => 'runway.is_enable', 'value' => $boolean['enable']), array('field' => 'runway.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('runway.runwayId', $runwayId)->get('tb_designer_runway as runway');

        if ($query->num_rows() > 0):
            $runway = $query->row();
            if (!$langId):
                $runway->langList = $this->get_runway_lang_select(array(array('field' => 'runwayId', 'value' => $runway->runwayId)));
            endif;

            return $runway;
        endif;

        return false;
    }

    public function insert_runway_message($runway)
    {
        $runway['order'] = $this->count_runway(array(array('field' => 'runway.designerId','value' => $runway['designerId'])))+1;
        $insert = $this->check_db_data($runway);        

        if (isset($runway['langList'])):
            foreach ($runway['langList'] as $i => $lrow):
                $runway['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_runway_lang($runway['runwayId'], $runway['langList']);
        endif;
        $this->db->insert('tb_designer_runway', $insert);

        return $this->db->insert_id();
    }

    public function update_runway_message($runway, $update)
    {
        if (isset($update['langList'])):
            foreach ($update['langList'] as $i => $lrow):
                $update['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_runway_lang($runway->runwayId, $update['langList']);
        endif;
        $update = $this->check_db_data($update);

        $this->db->update('tb_designer_runway', $update, array('runwayId' => $runway->runwayId));
        return true;
    }

    public function delete_runway_message($runway)
    {
        $this->update_runway($runway, array('is_enable' => 0));
        return true;
    }

    /******************** End runway Model ********************/

    /******************** Private Function ********************/
    /*************** 處理資料 ***************/
    private function check_db_data($runway)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($runway as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    case 'content':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'runwayId', 'designerId', /* runway Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}