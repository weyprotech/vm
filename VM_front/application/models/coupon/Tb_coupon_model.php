<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_coupon_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /******************** coupon Model ********************/
    public function get_coupon_select($filter = false, $order = false, $limit = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('coupon.is_enable', 1)->get('tb_coupon as coupon');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_coupon($filter = false)
    {
        $this->set_filter($filter);
        return $this->db->where('coupon.is_enable', 1)->count_all_results('tb_coupon as coupon');
    }

    public function get_coupon_by_id($couponId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_filter(array(array('field' => 'coupon.is_enable', 'value' => $boolean['enable'])));
        $query = $this->db->where('coupon.couponId', $couponId)->get('tb_coupon as coupon');

        if ($query->num_rows() > 0):
            $coupon = $query->row();
            return $coupon;
        endif;

        return false;
    }

    public function insert_coupon($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $insert = $this->check_db_data($post);
        $this->db->insert('tb_coupon', $insert);
        $couponId = $this->db->insert_id();

        return $couponId;
    }

    public function update_coupon($coupon, $post)
    {
        $update = $this->check_db_data($post);
        $this->db->update('tb_coupon', $update, array('couponId' => $coupon->couponId));
        return true;
    }

    public function delete_coupon($coupon)
    {
        $this->update_coupon($coupon, array('is_enable' => 0));
        return true;
    }

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
                            'couponId', 'cId', 'sId', /* coupon Field */
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