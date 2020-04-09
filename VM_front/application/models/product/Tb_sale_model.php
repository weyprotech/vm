<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_sale_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('product/sale/'); // 上傳路徑
    }

    /******************** sale Model ********************/
    /******************** start sale_information **************/
    public function get_sale_information($langId = false){
        if($langId){
            $this->db->select('sale_information.*,lang.title,lang.content');
            $this->db->join('tb_sale_information_lang as lang','sale_information.Id = lang.iId AND lang.langId = '.$langId,'left');
        }
        $query = $this->db->where('sale_information.Id',1)->get('tb_sale_information as sale_information');

        if($query->num_rows() > 0){
            $sale_information = $query->row();
            if (!$langId):
                $sale_information->langList = $this->get_sale_information_lang(array(array('field' => 'iId', 'value' => $sale_information->Id)));
            endif;

            return $sale_information;
        }
        return false;
    }

    public function update_sale_information($post){
        $update = $this->check_db_data($post);
        if (isset($_FILES['informationImg']) && !$_FILES['informationImg']['error']):
            $update['informationImg'] = $this->uploadFile('information', 'information' . '/', 631);
        endif;
        $this->update_product_lang($post['langList']);
        $this->db->update('tb_sale_information',$update,array('Id' => 1));
        return true;
    }

    /*************** Product Lang Model ***************/
    private function get_sale_information_lang($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_sale_information_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;
        return $langList;
    }

    private function update_product_lang($update)
    {
        $this->db->where('iId', 1)->update_batch('tb_sale_information_lang', $update, 'langId');

        $langList = $this->get_sale_information_lang(array(array('field' => 'iId', 'value' => 1)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_sale_information_lang', $insert);
        endif;

        return true;
    }

    /********************* end sale_information *****************/
    /********************* start sale product *******************/
    public function get_sale_product_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_sale_product_join($langId);
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->get('tb_sale_product as sale_product');

        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function get_sale_product_by_id($Id,$langId = false){
        $this->set_sale_product_join($langId);

        $query = $this->db->where('Id',$Id)->get('tb_sale_product as sale_product');
        if($query->num_rows() > 0):
            return $query->row();
        endif;

        return false;
    }

    //用產品id找特價商品
    public function get_sale_product_by_pId($pId){
        $query = $this->db->where('pId',$pId)->get('tb_sale_product as sale_product');
        if($query->num_rows() > 0):
            return $query->row();
        endif;
        return false;
    }

    public function count_sale_product($filter = false, $langId = false)
    {
        $this->set_sale_product_join($langId);
        $this->set_filter($filter);
        return $this->db->count_all_results('tb_sale_product as sale_product');
    }

    public function insert_sale_product($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $insert = $this->check_db_data($post);
        unset($insert['uuid']);
        $this->db->insert('tb_sale_product', $insert);
        return true;
    }
    public function delete_sale_product($sale)
    {
        $this->db->delete('tb_sale_product', array('Id' => $sale->Id));

        return true;
    }   
   
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

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'saleId', 'cId', 'pId', /* sale Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }

    private function set_sale_product_join($langId)
    {
        $this->db->select('sale_product.*,product.cId as categoryId,product.productImg as productImg,product.price as original_price, minor.prevId as mainId, minor.categoryId as minorId,base.categoryId as baseId');
        $this->db->join('tb_product as product', 'product.productId = sale_product.pId AND product.is_enable = 1', 'left');
        $this->db->join('tb_product_category as minor', 'minor.categoryId = product.cId AND minor.is_enable = 1', 'left');
        $this->db->join('tb_product_category as main', 'main.categoryId = minor.prevId AND main.is_enable', 'left');
        $this->db->join('tb_product_category as base','base.categoryId = main.prevId AND base.is_enable','left');
        if ($langId):
            $this->db->select('lang.*, main_lang.name as mainName, minor_lang.name as minorName,base_lang.name as baseName');
            $this->db->join('tb_product_lang as lang', 'lang.pId = product.productId AND lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as main_lang', 'main_lang.cId = minor.prevId AND main_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as minor_lang', 'minor_lang.cId = product.cId AND minor_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as base_lang','base_lang.cId = base.categoryId AND base_lang.langId = '.$langId,'left');
        endif;

        return true;
    }    
    /******************** 處理資料 ********************/
}