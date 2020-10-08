<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_brand_category_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('brand/brand_category/'); // 上傳路徑
    }

    /******************** Category Model ********************/
    public function get_category_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        if ($langId):
            $this->db->select('category.*, lang.name');
            $this->db->join('tb_brand_category_lang as lang', 'lang.categoryId = category.categoryId AND lang.langId = ' . $langId, 'inner');    
        endif;        
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('category.is_enable', 1)->get('tb_brand_category as category');

        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_category($filter = false, $langId = false)
    {
        if ($langId):
            $this->db->select('category.*, lang.name');
            $this->db->join('tb_brand_category_lang as lang', 'lang.categoryId = category.categoryId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter($filter);
        return $this->db->where('category.is_enable', 1)->count_all_results('tb_brand_category as category');
    }

    public function get_category_by_id($categoryId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        if ($langId):
            $this->db->select('category.*, lang.name');
            $this->db->join('tb_brand_category_lang as lang', 'lang.categoryId = category.categoryId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter(array(array('field' => 'category.is_enable', 'value' => $boolean['enable']), array('field' => 'category.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('category.categoryId', $categoryId)->get('tb_brand_category as category');

        if ($query->num_rows() > 0):
            $category = $query->row();
            if (!$langId):
                $category->langList = $this->get_category_lang_select(array(array('field' => 'categoryId', 'value' => $category->categoryId)));
            endif;

            return $category;
        endif;

        return false;
    }

    public function insert_category($post)
    {
        $insert = $this->check_db_data($post);
        $this->db->insert('tb_brand_category', $insert);
        $categoryId = $this->db->insert_id();
        $this->insert_category_lang($categoryId, $post["langList"]);
        return true;
    }

    public function update_category($category, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_category_lang($category->categoryId, $post['langList']);
        endif;

        $this->db->update('tb_brand_category', $update, array('categoryId' => $category->categoryId));
        return true;
    }

    public function delete_category($category)
    {
        $this->db->update('tb_brand_category', array('is_enable' => 0), array('categoryId' => $category->categoryId));
        return true;
    }


    /*************** Category Lang Model ***************/
    private function get_category_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_brand_category_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function insert_category_lang($categoryId, $post)
    {        
        foreach ($post as $i => $lrow):
            $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            $insert[$i]["categoryId"] = $categoryId;
        endforeach;
        $this->db->insert_batch('tb_brand_category_lang', $insert);

        return true;
    }

    private function update_category_lang($categoryId, $update)
    {
        $this->db->where('categoryId', $categoryId)->update_batch('tb_brand_category_lang', $update, 'langId');

        $langList = $this->get_category_lang_select(array(array('field' => 'categoryId', 'value' => $categoryId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_brand_category_lang', $insert);
        endif;

        return true;
    }
    /*************** End Category Lang Model ***************/
    /******************** End Category Model ********************/

    /******************** Private Function ********************/
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'categoryId', 'prevId', 'lv', 'categoryId'/* Category Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}