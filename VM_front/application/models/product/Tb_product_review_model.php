<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_product_review_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('product/product/'); // 上傳路徑
    }

    /******************** product Model ********************/
    public function get_product_review_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $this->set_product_join($langId);
        $query = $this->db->get('tb_product_review as review');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_product_review($filter = false, $langId = false)
    {
        $this->set_filter($filter);        
        $this->set_product_join($langId);

        return $this->db->count_all_results('tb_product_review as review');
    }

    public function get_product_review_by_id($Id = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {        
        $query = $this->db->where('review.Id', $Id)->get('tb_product_review as review');

        if ($query->num_rows() > 0):
            return $query->row();
        endif;

        return false;
    }

    public function insert_product_review($post)
    {

        $insert = $this->check_db_data($post);    

        $this->insert('tb_product_review', $insert);
        return $this->db->insert_id();
    }

    public function update_product_review($review, $post)
    {
        $update = $this->check_db_data($post);

        $this->update('tb_product_review', $update, array('Id' => $review->Id));
        return true;
    }

    public function delete_product_review($review)
    {
        $this->db->delete('tb_product_review',array('Id' => $review->Id));
        return true;
    }

    private function set_product_join($langId)
    {
        $this->db->select('review.*,product.*, minor.prevId as mainId, product.cId as minorId');
        $this->db->join('tb_product as product','product.productId = review.productId','left');
        $this->db->join('tb_product_category as minor', 'minor.categoryId = product.cId AND minor.is_enable = 1', 'left');
        $this->db->join('tb_product_category as main', 'main.categoryId = minor.prevId AND main.is_enable = 1', 'left');
        $this->db->join('tb_product_category as base','base.categoryId = main.prevId AND base.is_enable = 1','left');
        if ($langId):
            $this->db->select('lang.*, main_lang.name as mainName, minor_lang.name as minorName,base_lang.name as baseName');
            $this->db->join('tb_product_lang as lang', 'lang.pId = product.productId AND lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as main_lang', 'main_lang.cId = minor.prevId AND main_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as minor_lang', 'minor_lang.cId = product.cId AND minor_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as base_lang','base_lang.cId = base.categoryId AND base_lang.langId = '.$langId,'left');
        endif;

        return true;
    }

    /******************** End product Model ********************/
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
                            'productId', 'cId' /* product Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}