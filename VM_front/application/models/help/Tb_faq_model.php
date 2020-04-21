<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_faq_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('faq/faq/'); // 上傳路徑
    }

    /******************** faq Model ********************/
    public function get_faq_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_faq_join($langId);
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('faq.is_enable', 1)->get('tb_faq as faq');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_faq($filter = false, $langId = false)
    {
        $this->set_faq_join($langId);
        $this->set_filter($filter);
        return $this->db->where('faq.is_enable', 1)->count_all_results('tb_faq as faq');
    }

    public function get_faq_by_id($faqId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_faq_join($langId);
        $this->set_filter(array(array('field' => 'faq.is_enable', 'value' => $boolean['enable']), array('field' => 'faq.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('faq.faqId', $faqId)->get('tb_faq as faq');

        if ($query->num_rows() > 0):
            $faq = $query->row();
            if (!$langId):
                $faq->langList = $this->get_faq_lang_select(array(array('field' => 'fId', 'value' => $faq->faqId)));
            endif;

            return $faq;
        endif;

        return false;
    }

    public function insert_faq($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $insert = $this->check_db_data($post);
        if (isset($_FILES['faqImg']) && !$_FILES['faqImg']['error']):
            $insert['faqImg'] = $this->uploadFile('faq', $post['faqId'] . '/', 300);
        endif;
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_faq_lang($post['faqId'], $post['langList']);
        endif;

        $this->db->insert('tb_faq', $insert);
        return true;
    }

    public function update_faq($faq, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($_FILES['faqImg']) && !$_FILES['faqImg']['error']):
            $update['faqImg'] = $this->uploadFile('faq', $faq->faqId . '/', 300);
            @unlink($faq->faqImg);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_faq_lang($faq->faqId, $post['langList']);
        endif;

        $this->db->update('tb_faq', $update, array('faqId' => $faq->faqId));
        return true;
    }

    public function delete_faq($faq)
    {
        $this->update_faq($faq, array('is_enable' => 0));
        return $this->reorder_faq($faq->cId);
    }

    /*************** 重新排序 ***************/
    private function reorder_faq($cId)
    {
        $result = $this->get_faq_select(array(array('field' => 'faq.cId', 'value' => $cId)), array(array('field' => 'faq.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('faqId' => $row->faqId, 'order' => $i + 1));
            endforeach;

            return $this->db->update_batch('tb_faq', $order, 'faqId');
        endif;

        return true;
    }

    /*************** faq Lang Model ***************/
    private function get_faq_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_faq_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_faq_lang($faqId, $update)
    {
        $this->db->where('fId', $faqId)->update_batch('tb_faq_lang', $update, 'langId');

        $langList = $this->get_faq_lang_select(array(array('field' => 'fId', 'value' => $faqId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_faq_lang', $insert);
        endif;

        return true;
    }
    /*************** End faq Lang Model ***************/    
    /******************** Private Function ********************/
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
                            'faqId', 'cId', 'fId', /* faq Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }

    private function set_faq_join($langId)
    {
        $this->db->select('faq.*');       
        if ($langId):
            $this->db->select('lang.*');
            $this->db->join('tb_faq_lang as lang', 'lang.fId = faq.faqId AND lang.langId = ' . $langId, 'left');
        endif;

        return true;
    }
    /******************** End Private Function ********************/
}