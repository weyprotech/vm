<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_topic_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('topic/topic/'); // 上傳路徑
    }

    /******************** topic Model ********************/
    public function get_topic_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        if($langId){
            $this->db->select('topic.*,lang.topic');
            $this->db->join('tb_feedback_topic_lang as lang','lang.tId = topic.topicId AND lang.langId ='.$langId,'left');
        }
        $query = $this->db->where('topic.is_enable', 1)->get('tb_feedback_topic as topic');
        if ($query->num_rows() > 0):
            $result = $query->result();
            if(!$langId){
                foreach($result as $i => $row){
                    $result->langList = $this->get_topic_lang_select(array(array('field' => 'tb_feedback_topic_lang.tId','value' => $row->topicId)));
                }
            }
            return $result;
            
        endif;

        return false;
    }

    public function count_topic($filter = false,$langId = false)
    {        
        $this->set_filter($filter);
        if($langId){
            $this->db->select('topic.*,lang.topic');
            $this->db->join('tb_feedback_topic_lang as lang','lang.tId = topic.topicId AND lang.langId ='.$langId,'left');
        }
        return $this->db->where('topic.is_enable', 1)->count_all_results('tb_feedback_topic as topic');
    }

    public function get_topic_by_id($topicId = false,$langId = false)
    {        
        if($langId){
            $this->db->select('topic.*,lang.topic');
            $this->db->join('tb_feedback_topic_lang as lang','lang.tId = topic.topicId AND lang.langId ='.$langId,'left');
        }
        $query = $this->db->where('topic.topicId', $topicId)->get('tb_feedback_topic as topic');
        
        if ($query->num_rows() > 0):
            $topic = $query->row();
            $topic->langList = $this->get_topic_lang_select(array(array('field' => 'tb_feedback_topic_lang.tId','value' => $topic->topicId)));

            return $topic;
        endif;

        return false;
    }

    public function insert_topic($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $post['order'] = $this->count_topic() + 1;

        $insert = $this->check_db_data($post);
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_topic_lang($post['topicId'], $post['langList']);
        endif;

        $this->db->insert('tb_feedback_topic', $insert);
        return true;
    }

    public function update_topic($topic, $post)
    {
        $update = $this->check_db_data($post);
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_topic_lang($topic->topicId, $post['langList']);
        endif;

        $this->db->update('tb_feedback_topic', $update, array('topicId' => $topic->topicId));
        return true;
    }

    public function delete_topic($topic)
    {
        $this->update_topic($topic, array('is_enable' => 0));
    }

    /*************** topic Lang Model ***************/
    private function get_topic_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_feedback_topic_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_topic_lang($topicId, $update)
    {
        $this->db->where('tId', $topicId)->update_batch('tb_feedback_topic_lang', $update, 'langId');

        $langList = $this->get_topic_lang_select(array(array('field' => 'tId', 'value' => $topicId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_feedback_topic_lang', $insert);
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
                            'topicId', 'cId', 'tId', /* topic Field */
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