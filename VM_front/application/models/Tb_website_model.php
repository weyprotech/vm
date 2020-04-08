<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_website_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this);
    }

    public function get_lang_select($filter = false, $order = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $query = $this->db->where('lang.is_enable', 1)->get('tb_website_lang as lang');
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }

    public function count_lang($filter = false)
    {
        $this->set_filter($filter);
        return $this->db->where('lang.is_enable', 1)->count_all_results('tb_website_lang as lang');
    }

    public function get_lang_by_id($langId = false, $boolean = array('enable' => true))
    {
        $this->set_filter(array(array('field' => 'lang.is_enable', 'value' => $boolean['enable'])));
        $query = $this->db->where('lang.langId', $langId)->get('tb_website_lang as lang');
        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return false;
    }

    public function get_lang_by_locale($locale = false)
    {
        $query = $this->db->where('lang.locale', $locale)->get('tb_website_lang as lang');
        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return false;
    }

    public function insert_lang()
    {
        $insert = $this->check_db_data(array(
            'order' => $this->count_lang() + 1
        ));

        $this->insert('tb_website_lang', $insert);
        return $this->db->insert_id();
    }

    public function update_lang($langId, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($update['isPreset']) && $update['isPreset']) {
            $this->db->update('tb_website_lang', $this->check_db_data(array('isPreset' => 0)), array('isPreset' => 1, 'langId <>' => $langId));
        }

        $this->update('tb_website_lang', $update, array('langId' => $langId));
        return true;
    }

    public function delete_lang($langId)
    {
        $this->delete('tb_website_lang', $this->check_db_data(array('is_enable' => 0)), array('langId' => $langId));
        return $this->reorder_lang();
    }

    /**
     * 重新排序
     */
    private function reorder_lang()
    {
        $result = $this->get_lang_select(false, array(array('field' => 'lang.order', 'dir' => 'asc')));
        if ($result) {
            foreach ($result as $i => $row) {
                $order[] = $this->check_db_data(array('langId' => $row->langId, 'order' => $i + 1));
            }
            $this->db->update_batch('tb_website_lang', $order, 'langId');
        }

        return true;
    }

    /******************** Private Function ********************/
    /**
     * 處理資料
     */
    private function check_db_data($post)
    {
        $data = array();

        foreach ($post as $field => $value) {
            if (!in_array($field, array('langList', 'uuid'))) {
                switch ($field) {
                    default :
                        $int_array = array(
                            'is_enable', 'langId', 'order', /* Common Field */
                            'is_preset' /* Lang Field */
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                }
            }
        }

        return $data;
    }
    /******************** End Private Function ********************/
}
