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
        $query = $this->db->get('tb_product_review as review');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_product_review($filter = false, $langId = false)
    {
        $this->set_filter($filter);        
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