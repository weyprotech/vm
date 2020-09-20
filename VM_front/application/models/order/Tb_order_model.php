<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_order_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /******************** order Model ********************/
    public function get_order_select($filter = false, $order = false, $limit = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('order.is_enable', 1)->get('tb_order as order');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_order($filter = false)
    {
        $this->set_filter($filter);
        return $this->db->where('order.is_enable', 1)->count_all_results('tb_order as order');
    }

    public function get_order_by_id($orderId = false, $boolean = array('enable' => true, 'visible' => true),$langId = 3)
    {
        $this->set_filter(array(array('field' => 'order.is_enable', 'value' => $boolean['enable'])));
        $this->set_member_join();
        $query = $this->db->where('order.orderId', $orderId)->get('tb_order as order');

        if ($query->num_rows() > 0):
            $order = $query->row();
            $order->productList = $this->get_order_product_select(array(array('field' => 'product.orderId','value' => $orderId)));
            return $order;
        endif;

        return false;
    }

    public function insert_order($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $post['orderId'] = uniqid();
        $productList = $post['productList'];
        unset($post['productList']);
        $insert = $this->check_db_data($post);
        $this->db->insert('tb_order', $insert);
        
        if (isset($productList)):
            foreach ($productList as $i => $lrow):
                $productList[$i]['orderId'] = $post['orderId'];
                $productList[$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_order_product($post['orderId'], $productList);
        endif;

        return $post['orderId'];
    }

    public function update_order($order, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($post['productList'])):
            foreach ($post['productList'] as $i => $lrow):
                $post['productList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_order_product($order->orderId, $post['productList']);
        endif;

        $this->db->update('tb_order', $update, array('orderId' => $order->orderId));
        return true;
    }

    public function delete_order($order)
    {
        $this->update_order($order, array('is_enable' => 0));
        return true;
    }

    /*************** order product Model ***************/
    private function get_order_product_select($filter = false,$langId = 3)
    {
        $productList = array();
        $this->set_filter($filter);
        $this->set_product_join($langId);
        $query = $this->db->get('tb_order_product as product');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $productList[$lrow->productId] = $lrow;
            endforeach;
        endif;

        return $productList;
    }

    private function update_order_product($orderId, $update)
    {
        $this->db->where('orderId', $orderId)->update_batch('tb_order_product', $update, 'productId');
        $productList = $this->get_order_product_select(array(array('field' => 'orderId', 'value' => $orderId)));
        $insert = array_diff_key($update, $productList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $lrow['orderId'] = $orderId;
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_order_product', $insert);
        endif;

        return true;
    }
    
    private function set_product_join($langId){
        $this->db->select('product.*,product_detail.productImg as img,lang.*');
        $this->db->join('tb_product as product_detail', 'product_detail.productId = product.productId','left');
        $this->db->join('tb_product_lang as lang', 'lang.pId = product.productId AND lang.langId = ' . $langId, 'left');

    }

    private function set_member_join(){
        $this->db->select('order.*,member.first_name,member.last_name,member.address as member_address,member.phone as member_phone,member.birthday,member.country as member_country,member.state as member_state,member.phone_area_code as member_phone_area_code');
        $this->db->join('tb_member as member','order.memberId = member.memberId','left');
    }
   
    /******************** Private Function ********************/
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('mainId', 'imageOrder', 'productList', 'uuid','image_list_length'))):
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
                            'is_enable', 'is_visible', 'productId', 'order', /* Common Field */
                            'orderId', 'cId', 'sId', /* order Field */
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