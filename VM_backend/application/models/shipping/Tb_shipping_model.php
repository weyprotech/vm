<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_shipping_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /******************** shipping Model ********************/
    public function get_shipping_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_shipping_join($langId);
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('shipping.is_enable', 1)->get('tb_shipping as shipping');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_shipping($filter = false, $langId = false)
    {
        $this->set_shipping_join($langId);
        $this->set_filter($filter);
        return $this->db->where('shipping.is_enable', 1)->count_all_results('tb_shipping as shipping');
    }

    public function get_shipping_by_id($shippingId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_shipping_join($langId);
        $this->set_filter(array(array('field' => 'shipping.is_enable', 'value' => $boolean['enable']), array('field' => 'shipping.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('shipping.shippingId', $shippingId)->get('tb_shipping as shipping');

        if ($query->num_rows() > 0):
            $shipping = $query->row();
            if (!$langId):
                $shipping->langList = $this->get_shipping_lang_select(array(array('field' => 'sId', 'value' => $shipping->shippingId)));
            endif;

            return $shipping;
        endif;

        return false;
    }

    public function insert_shipping($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $post['order'] = $this->count_shipping(false,false)+1;
        $insert = $this->check_db_data($post);
        $this->db->insert('tb_shipping', $insert);
        $shippingId = $this->db->insert_id();
        
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_shipping_lang($shippingId, $post['langList']);
        endif;

        return $shippingId;
    }

    public function update_shipping($shipping, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_shipping_lang($shipping->shippingId, $post['langList']);
        endif;

        $this->db->update('tb_shipping', $update, array('shippingId' => $shipping->shippingId));
        return true;
    }

    public function delete_shipping($shipping)
    {
        $this->update_shipping($shipping, array('is_enable' => 0));
        return $this->reorder_shipping($shipping->cId);
    }

    /*************** 重新排序 ***************/
    private function reorder_shipping($sId)
    {
        $result = $this->get_shipping_select(array(array('field' => 'shipping.sId', 'value' => $sId)), array(array('field' => 'shipping.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('shippingId' => $row->shippingId, 'order' => $i + 1));
            endforeach;

            return $this->db->update_batch('tb_shipping', $order, 'shippingId');
        endif;

        return true;
    }

    /*************** shipping Lang Model ***************/
    private function get_shipping_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_shipping_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_shipping_lang($shippingId, $update)
    {
        $this->db->where('sId', $shippingId)->update_batch('tb_shipping_lang', $update, 'langId');
        $langList = $this->get_shipping_lang_select(array(array('field' => 'sId', 'value' => $shippingId)));

        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $lrow['sId'] = $shippingId;
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_shipping_lang', $insert);
        endif;

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
                            'shippingId', 'cId', 'sId', /* shipping Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }

    private function set_shipping_join($langId)
    {
        $this->db->select('shipping.*');
        if ($langId):
            $this->db->select('lang.*');
            $this->db->join('tb_shipping_lang as lang', 'lang.sId = shipping.shippingId AND lang.langId = ' . $langId, 'left');            
        endif;

        return true;
    }
    /******************** End Private Function ********************/
}