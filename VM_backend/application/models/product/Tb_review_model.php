<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_review_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('designer/review/'); // 上傳路徑
    }

    /******************** review Model ********************/
    public function get_review_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        if ($langId):
            $this->db->select('review.*,designer.*, designer_lang.name as designer_name,product_lang.name as product_name,member.first_name as member_first_name,member.last_name as member_last_name');
            $this->db->join('tb_designer as designer','designer.designerId = review.designerId','left');
            $this->db->join('tb_designer_lang as designer_lang','designer_lang.designerId = designer.designerId AND designer_lang.langId ='.$langId,'left');
            $this->db->join('tb_product as product','product.productId = review.productId','left');
            $this->db->join('tb_product_lang as product_lang','product.productId = product_lang.pId AND product_lang.langId ='.$langId,'left');
            $this->db->join('tb_member as member','member.memberId = review.memberId','left');
        endif;
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('review.is_enable', 1)->get('tb_product_review as review');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_review($filter = false, $langId = false)
    {
        if ($langId):
            $this->db->select('review.*,designer.*, designer_lang.name as designer_name,product_lang.name as product_name,member.first_name as member_first_name,member.last_name as member_last_name');
            $this->db->join('tb_designer as designer','designer.designerId = review.designerId','left');
            $this->db->join('tb_designer_lang as designer_lang','designer_lang.designerId = designer.designerId AND designer_lang.langId ='.$langId,'left');
            $this->db->join('tb_product as product','product.productId = review.productId','left');
            $this->db->join('tb_product_lang as product_lang','product.productId = product_lang.pId AND product_lang.langId ='.$langId,'left');
            $this->db->join('tb_member as member','member.memberId = review.memberId','left');
        endif;
        $this->set_filter($filter);
        return $this->db->where('review.is_enable', 1)->count_all_results('tb_product_review as review');
    }

    public function get_review_by_id($reviewId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        if ($langId):
            $this->db->select('review.*,designer.*, designer_lang.name as designer_name,product_lang.name as product_name,member.first_name as member_first_name,member.last_name as member_last_name');
            $this->db->join('tb_designer as designer','designer.designerId = review.designerId','left');
            $this->db->join('tb_designer_lang as designer_lang','designer_lang.designerId = designer.designerId AND designer_lang.langId ='.$langId,'left');
            $this->db->join('tb_product as product','product.productId = review.productId','left');
            $this->db->join('tb_product_lang as product_lang','product.productId = product_lang.pId AND product_lang.langId ='.$langId,'left');
            $this->db->join('tb_member as member','member.memberId = review.memberId','left');
        endif;
        $this->set_filter(array(array('field' => 'review.is_enable', 'value' => $boolean['enable']), array('field' => 'review.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('review.Id', $reviewId)->get('tb_product_review as review');

        if ($query->num_rows() > 0):
            $review = $query->row();

            return $review;
        endif;

        return false;
    }

    public function insert_review($review)
    {
        $review['order'] = $this->count_review(array(array('field' => 'review.reviewId','value' => $review['reviewId'])))+1;
        $insert = $this->check_db_data($review);        

        $this->db->insert('tb_product_review', $insert);

        return $this->db->insert_id();
    }

    public function update_review($review, $update)
    {
        $update = $this->check_db_data($update);

        $this->db->update('tb_product_review', $update, array('Id' => $review->Id));
        return true;
    }

    public function delete_review($review)
    {
        $this->update_review($review, array('is_enable' => 0));
        return true;
    }

    /******************** End review Model ********************/

    /******************** Private Function ********************/
    /*************** 處理資料 ***************/
    private function check_db_data($review)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($review as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    // case 'content':
                    //     $data[$field] = check_input_value(html_entity_decode($value));
                    //     break;

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'reviewId', 'reviewId' /* review Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}