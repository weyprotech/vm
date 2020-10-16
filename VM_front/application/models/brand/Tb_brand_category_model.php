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

    /*************** End Category Lang Model ***************/
    /******************** End Category Model ********************/
}