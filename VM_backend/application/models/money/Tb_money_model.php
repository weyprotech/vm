<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_money_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('money/'); // 上傳路徑
    }

    /******************** money Model ********************/
    public function get_money_select($filter = false, $order = false, $limit = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->get('tb_money as money');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_money($filter = false)
    {
        $this->set_filter($filter);
        return $this->db->count_all_results('tb_money as money');
    }

    public function get_money_by_id($moneyId = false)
    {
        $query = $this->db->where('money.moneyId', $moneyId)->get('tb_money as money');

        if ($query->num_rows() > 0):
            $money = $query->row();

            return $money;
        endif;

        return false;
    }

    public function insert_money($post)
    {
        $post['create_at'] =  date("Y-m-d H:i:s");
        $insert = $this->check_db_data($post);

        $this->insert('tb_money', $insert);
        return $this->db->insert_id();
    }

    public function update_money($money, $post)
    {
        $update = $this->check_db_data($post);
        $this->update('tb_money', $update, array('moneyId' => $money->moneyId));
        return true;
    }

    public function delete_money($money)
    {
        $this->delete('tb_money', $money->moneyId);
        return true;
    }
    /******************** End money Model ********************/

    /******************** Private Function ********************/

    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('langList', 'uuid'))):
                switch ($field):
                    case 'detail':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;
                    default:
                        $int_array = array(                            
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** End Private Function ********************/
}