<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_designer_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('designer/designer/'); // 上傳路徑
    }

    /******************** designer Model ********************/
    public function get_designer_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_designer_join($langId);
        $query = $this->db->where('designer.is_enable', 1)->get('tb_designer as designer');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_designer($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_designer_join($langId);
        return $this->db->where('designer.is_enable', 1)->count_all_results('tb_designer as designer');
    }

    public function get_designer_by_id($designerId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_designer_join($langId);
        $this->set_filter(array(array('field' => 'designer.is_enable', 'value' => $boolean['enable']), array('field' => 'designer.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('designer.designerId', $designerId)->get('tb_designer as designer');
        if ($query->num_rows() > 0):
            $designer = $query->row();
            if (!$langId):
                $designer->langList = $this->get_designer_lang_select(array(array('field' => 'designerId', 'value' => $designer->designerId)));
            endif;

            return $designer;
        endif;

        return false;
    }

    public function insert_designer($post)
    {
        $post['order'] = $this->count_designer() + 1;
        $post['create_at'] =  date("Y-m-d H:i:s");
        $post['is_enable'] = 1;
        $post['is_visible'] = 1;
        $insert = $this->check_db_data($post);
        if (isset($_FILES['designiconImg']) && !$_FILES['designiconImg']['error']):
            $insert['designiconImg'] = $this->uploadFile('designicon', $post['designerId'] . '/', 100);
        endif;
        
        if (isset($_FILES['designImg']) && !$_FILES['designImg']['error']):
            $insert['designImg'] = $this->uploadFile('design', $post['designerId'] . '/', 540);
        endif;

        if (isset($_FILES['hometownpost1Img']) && !$_FILES['hometownpost1Img']['error']):
            $insert['hometownpost1Img'] = $this->uploadFile('hometownpost1', $post['designerId'] . '/', 360);
        endif;

        if (isset($_FILES['hometownpost2Img']) && !$_FILES['hometownpost2Img']['error']):
            $insert['hometownpost2Img'] = $this->uploadFile('hometownpost2', $post['designerId'] . '/', 360);
        endif;

        if (isset($_FILES['hometownpost3Img']) && !$_FILES['hometownpost3Img']['error']):
            $insert['hometownpost3Img'] = $this->uploadFile('hometownpost3', $post['designerId'] . '/', 360);
        endif;

        if (isset($_FILES['designerstoryImg']) && !$_FILES['designerstoryImg']['error']):
            $insert['designerstoryImg'] = $this->uploadFile('designerstory', $post['designerId'] . '/', 510);
        endif;

        if (isset($_FILES['aboutImg']) && !$_FILES['aboutImg']['error']):
            $insert['aboutImg'] = $this->uploadFile('about', $post['designerId'] . '/', 600);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_designer_lang($post['designerId'], $post['langList']);
        endif;

        $this->insert('tb_designer', $insert);
        return $this->db->insert_id();
    }

    public function update_designer($designer, $post)
    {
        $update = $this->check_db_data($post);
        if (isset($_FILES['designiconImg']) && !$_FILES['designiconImg']['error']):
            $update['designiconImg'] = $this->uploadFile('designicon', $designer->designerId . '/', 100);
        endif;
        if (isset($_FILES['designImg']) && !$_FILES['designImg']['error']):
            $update['designImg'] = $this->uploadFile('design', $designer->designerId . '/', 540);
        endif;
        if (isset($_FILES['hometownpost1Img']) && !$_FILES['hometownpost1Img']['error']):
            $update['hometownpost1Img'] = $this->uploadFile('hometownpost1', $designer->designerId . '/', 360);
        endif;

        if (isset($_FILES['hometownpost2Img']) && !$_FILES['hometownpost2Img']['error']):
            $update['hometownpost2Img'] = $this->uploadFile('hometownpost2', $designer->designerId . '/', 360);
        endif;

        if (isset($_FILES['hometownpost3Img']) && !$_FILES['hometownpost3Img']['error']):
            $update['hometownpost3Img'] = $this->uploadFile('hometownpost3', $designer->designerId . '/', 360);
        endif;

        if (isset($_FILES['designerstoryImg']) && !$_FILES['designerstoryImg']['error']):
            $update['designerstoryImg'] = $this->uploadFile('designerstory', $designer->designerId . '/', 510);
        endif;

        if (isset($_FILES['aboutImg']) && !$_FILES['aboutImg']['error']):
            $update['aboutImg'] = $this->uploadFile('about', $designer->designerId . '/', 600);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_designer_lang($designer->designerId, $post['langList']);
        endif;

        $this->update('tb_designer', $update, array('designerId' => $designer->designerId));
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
        if (isset($_FILES['personalImg']) && !$_FILES['personalImg']['error']):
            $update[3]['personalImg'] = $this->uploadFile('personal', $designerId . '/personal/', 1920);
        endif;
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

    /****************Start desinger  */
    /******************** End designer Model ********************/

    /******************** Private Function ********************/
    private function set_designer_join($langId)
    {
        $this->db->select('designer.*');
        if ($langId):
            $this->db->select('lang.name,lang.personal_title,lang.personal_content,lang.personalImg');
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
                    case 'personal_content':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;

                    case 'my_story_content':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;
                        
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