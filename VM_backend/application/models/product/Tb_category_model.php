<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_category_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('product/category/'); // 上傳路徑
    }

    /******************** Category Model ********************/
    public function get_category_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        if ($langId):
            $this->db->select('category.*,prev.categoryId as prev_categoryId, lang.name, prev_lang.name as prevName');
            $this->db->join('tb_product_category_lang as lang', 'lang.cId = category.categoryId AND lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as prev_lang', 'prev_lang.cId = category.prevId AND prev_lang.langId = ' . $langId, 'left');   
            $this->db->join('tb_product_category as prev','prev.categoryId = category.prevId','left');         
        endif;
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('category.is_enable', 1)->get('tb_product_category as category');

        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_category($filter = false, $langId = false)
    {
        if ($langId):
            $this->db->select('category.*, lang.name, prev_lang.name as prevName');
            $this->db->join('tb_product_category_lang as lang', 'lang.cId = category.categoryId AND lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as prev_lang', 'prev_lang.cId = category.prevId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter($filter);
        return $this->db->where('category.is_enable', 1)->count_all_results('tb_product_category as category');
    }

    public function get_category_by_id($categoryId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        if ($langId):
            $this->db->select('category.*, lang.name');
            $this->db->join('tb_product_category_lang as lang', 'lang.cId = category.categoryId AND lang.langId = ' . $langId, 'left');
        endif;
        $this->set_filter(array(array('field' => 'category.is_enable', 'value' => $boolean['enable']), array('field' => 'category.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('category.categoryId', $categoryId)->get('tb_product_category as category');

        if ($query->num_rows() > 0):
            $category = $query->row();
            if (!$langId):
                $category->langList = $this->get_category_lang_select(array(array('field' => 'cId', 'value' => $category->categoryId)));
            endif;

            return $category;
        endif;

        return false;
    }

    public function insert_category($post)
    {
        $post['lv'] = $post['prevId'] ? $this->get_category_by_id($post['prevId'])->lv + 1 : 1;
        $post['order'] = $this->count_category(array(array('field' => 'category.prevId', 'value' => $post['prevId']))) + 1;
        $post['create_at'] = date("Y-m-d H:i:s");

        if (isset($_FILES['categoryImg']) && !$_FILES['categoryImg']['error']):
            $post['categoryImg'] = $this->uploadFile('category', $post['categoryId'] . '/', 710);
        endif;

        if (isset($_FILES['category2Img']) && !$_FILES['category2Img']['error']):
            $post['category2Img'] = $this->uploadFile('category2', $post['categoryId'] . '/', 631);
        endif;

        if (isset($_FILES['category3Img']) && !$_FILES['category3Img']['error']):
            $post['category3Img'] = $this->uploadFile('category3', $post['categoryId'] . '/', 631);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_category_lang($post['categoryId'], $post['langList']);
        endif;
        $insert = $this->check_db_data($post);
        
        $this->db->insert('tb_product_category', $insert);
        return $this->db->insert_id();
    }

    public function update_category($category, $post)
    {
        $post['lv'] = $post['prevId'] ? $this->get_category_by_id($post['prevId'])->lv + 1 : 1;
        $update = $this->check_db_data($post);
        if (isset($_FILES['categoryImg']) && !$_FILES['categoryImg']['error']):
            $update['categoryImg'] = $this->uploadFile('category', $category->categoryId . '/', 710);
            @unlink($category->categoryImg);
        endif;

        if (isset($_FILES['category2Img']) && !$_FILES['category2Img']['error']):
            $update['category2Img'] = $this->uploadFile('category2', $category->categoryId . '/', 631);
            @unlink($category->category2Img);
        endif;

        if (isset($_FILES['category3Img']) && !$_FILES['category3Img']['error']):
            $update['category3Img'] = $this->uploadFile('category3', $category->categoryId . '/', 631);
            @unlink($category->category3Img);
        endif;
        
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_category_lang($category->categoryId, $post['langList']);
        endif;

        $this->db->update('tb_product_category', $update, array('categoryId' => $category->categoryId));
        return true;
    }

    public function delete_category($category)
    {
        $this->db->update('tb_product_category', array('is_enable' => 0), array('categoryId' => $category->categoryId));
        return true;
    }

    /*************** 重新排序 ***************/
    private function reorder_category($prevId = 0)
    {
        $result = $this->get_category_select(array(array('field' => 'category.prevId', 'value' => $prevId)), array(array('field' => 'category.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('categoryId' => $row->categoryId, 'order' => $i + 1));
            endforeach;
            return $this->db->update_batch('tb_product_category', $order, 'categoryId');
        endif;

        return true;
    }

    /*************** Category Lang Model ***************/
    private function get_category_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_product_category_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_category_lang($categoryId, $update)
    {
        $this->db->where('cId', $categoryId)->update_batch('tb_product_category_lang', $update, 'langId');

        $langList = $this->get_category_lang_select(array(array('field' => 'cId', 'value' => $categoryId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_product_category_lang', $insert);
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
                            'categoryId', 'prevId', 'lv', 'cId'/* Category Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}