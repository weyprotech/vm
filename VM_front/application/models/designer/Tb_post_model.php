<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_post_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->uploadPath .= 'post/';
    }

    /******************** post Model ********************/
    public function get_post_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        if ($langId):
            $this->db->select('post.*, lang.title, lang.content');
            $this->db->join('tb_designer_post_lang as lang', 'lang.postId = post.postId AND lang.langId = ' . $langId, 'left');
        endif;
        
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('post.is_enable', 1)->get('tb_designer_post as post');

        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_post($filter = false, $langId = false)
    {
        if ($langId):
            $this->db->select('post.*, lang.title, lang.content');
            $this->db->join('tb_designer_post_lang as lang', 'lang.postId = post.postId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter($filter);
        return $this->db->where('post.is_enable', 1)->count_all_results('tb_designer_post as post');
    }

    public function get_post_by_id($postId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        if ($langId):
            $this->db->select('post.*, lang.title, lang.content');
            $this->db->join('tb_designer_post_lang as lang', 'lang.postId = post.postId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter(array(array('field' => 'post.is_enable', 'value' => $boolean['enable']), array('field' => 'post.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('post.postId', $postId)->get('tb_designer_post as post');

        if ($query->num_rows() > 0):
            $post = $query->row();
            if (!$langId):
                $post->langList = $this->get_post_lang_select(array(array('field' => 'postId', 'value' => $post->postId)));
            endif;

            return $post;
        endif;

        return false;
    }

    public function insert_post($post)
    {
        $post['order'] = $this->count_post(array(array('field' => 'post.designerId','value' => $post['designerId'])))+1;
        $insert = $this->check_db_data($post);        

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_post_lang($post['postId'], $post['langList']);
        endif;
        $this->db->insert('tb_designer_post', $insert);

        return $this->db->insert_id();
    }

    public function update_post($post, $update)
    {
        if (isset($update['langList'])):
            foreach ($update['langList'] as $i => $lrow):
                $update['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_post_lang($post->postId, $update['langList']);
        endif;
        $update = $this->check_db_data($update);

        $this->db->update('tb_designer_post', $update, array('postId' => $post->postId));
        return true;
    }

    public function delete_post($post)
    {
        $this->update_post($post, array('is_enable' => 0));
        return true;
    }

    /*************** Story Lang Model ***************/
    private function get_post_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_designer_post_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_post_lang($postId, $update)
    {
        $this->db->where('postId', $postId)->update_batch('tb_designer_post_lang', $update, 'langId');

        $langList = $this->get_post_lang_select(array(array('field' => 'postId', 'value' => $postId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_designer_post_lang', $insert);
        endif;

        return true;
    }
    /*************** End Story Lang Model ***************/
    /********** Post img Model *************/
    public function get_post_img_select($filter = false,$order = false,$limit = false){
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->get('tb_designer_post_img as post_img');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function get_post_img_by_id($id){
        $query = $this->db->where('Id',$id)->get('tb_designer_post_img as post_img');
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function count_post_img($filter = false){
        $this->set_filter($filter);
        $count = $this->db->count_all_results('tb_designer_post_img as post_img');
        return $count;
    }

    public function insert_post_img($post){
        $insert = $post;
        $insert['order'] = $this->count_post_img() + 1;

        $this->db->insert('tb_designer_post_img',$insert);

        return $this->db->insert_id();
    }

    public function update_post_img_select($img,$post){
        $update = $post;
        $this->db->update('tb_designer_post_img',$update,array('Id' => $img->Id));
        return true;
    }

    public function delete_post_img($img){
        //刪除圖檔
        if(file_exists($this->uploadPath .$img->postImg)){
            @chmod($this->uploadPath .$img->postImg, 0777);
            @unlink($this->uploadPath .$img->postImg);
        }
        $this->db->delete('tb_designer_post_img',array('Id' => $img->Id));

        return true;
    }
    /********* End post img model *********/
    /********* Start post message model *******/
    public function get_post_message_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_message_join();
        $query = $this->db->get('tb_designer_post_message as message');    

        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_post_message($filter = false, $langId = false)
    {
        if ($langId):
            $this->db->select('post.*, lang.title, lang.content');
            $this->db->join('tb_designer_post_lang as lang', 'lang.postId = post.postId AND lang.langId = ' . $langId, 'left');
            $this->db->join('tb_designer_post_message as message','message.postId = post.postid','left');
        endif;
        $this->set_filter($filter);
        return $this->db->where('post.is_enable', 1)->count_all_results('tb_designer_post as post');
    }

    public function get_post_message_by_id($postId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        if ($langId):
            $this->db->select('post.*, lang.title, lang.content');
            $this->db->join('tb_designer_post_lang as lang', 'lang.postId = post.postId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter(array(array('field' => 'post.is_enable', 'value' => $boolean['enable']), array('field' => 'post.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('post.postId', $postId)->get('tb_designer_post as post');

        if ($query->num_rows() > 0):
            $post = $query->row();
            if (!$langId):
                $post->langList = $this->get_post_lang_select(array(array('field' => 'postId', 'value' => $post->postId)));
            endif;

            return $post;
        endif;

        return false;
    }

    public function insert_post_message($post)
    {
        $post['order'] = $this->count_post(array(array('field' => 'post.designerId','value' => $post['designerId'])))+1;
        $insert = $this->check_db_data($post);        

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_post_lang($post['postId'], $post['langList']);
        endif;
        $this->db->insert('tb_designer_post', $insert);

        return $this->db->insert_id();
    }

    public function update_post_message($post, $update)
    {
        if (isset($update['langList'])):
            foreach ($update['langList'] as $i => $lrow):
                $update['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_post_lang($post->postId, $update['langList']);
        endif;
        $update = $this->check_db_data($update);

        $this->db->update('tb_designer_post', $update, array('postId' => $post->postId));
        return true;
    }

    public function delete_post_message($post)
    {
        $this->update_post($post, array('is_enable' => 0));
        return true;
    }

    /******************** End post Model ********************/

    /******************** Private Function ********************/
    private function set_message_join(){
        $this->db->select('message.*,member.*');
        $this->db->join('tb_member as member','message.memberId = member.memberId','left');
    }
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    case 'content':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'postId', 'postId' /* post Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}