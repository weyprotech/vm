<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_product_like_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->model = get_class($this); // 本身Model
        $this->checkUploadPath('product_like/product_like/'); // 上傳路徑
    }

    /******************** product_like Model ********************/
    public function get_product_like_select($filter = false, $order = false, $limit = false, $langId = false,$join = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        if($join){
            $this->set_product_join($langId);
        }
        $query = $this->db->get('tb_product_like as product_like');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_product_like($filter = false, $langId = false)
    {
        $this->set_filter($filter);
        return $this->db->count_all_results('tb_product_like as product_like');
    }

    public function get_product_like_by_id($product_likeId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_filter(array(array('field' => 'product_like.is_enable', 'value' => $boolean['enable']), array('field' => 'product_like.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('product_like.product_likeId', $product_likeId)->get('tb_product_like as product_like');
        if ($query->num_rows() > 0):
            $product_like = $query->row();
            return $product_like;
        endif;

        return false;
    }

    public function insert_product_like($post)
    {
        $this->insert('tb_product_like', $post);
        return $this->db->insert_id();
    }

    public function update_product_like($product_like, $post)
    {
        $this->update('tb_product_like', $post, array('Id' => $product_like->Id));
        return true;
    }

    public function delete_product_like($product_like)
    {
        $this->db->delete('tb_product_like',array('Id' => $product_like->Id));        
        return true;
    }

    private function set_product_join($langId)
    {
        $this->db->select('product.*, minor.prevId as mainId, product.cId as minorId,brand.brandId,designer.designerId,designer.designiconImg');
        $this->db->join('tb_product as product','product.productId = product_like.productId AND product.is_enable = 1 AND product.is_visible = 1', 'left');
        $this->db->join('tb_product_category as minor', 'minor.categoryId = product.cId AND minor.is_enable = 1', 'left');
        $this->db->join('tb_product_category as main', 'main.categoryId = minor.prevId AND main.is_enable = 1', 'left');
        $this->db->join('tb_product_category as base','base.categoryId = main.prevId AND base.is_enable = 1','left');
        $this->db->join('tb_brand as brand','brand.brandId = product.brandId','left');
        $this->db->join('tb_designer as designer','designer.designerId = brand.designerId','left');
        if ($langId):
            $this->db->select('lang.*, main_lang.name as mainName, minor_lang.name as minorName,base_lang.name as baseName,designer_lang.name as designerName');
            $this->db->join('tb_product_lang as lang', 'lang.pId = product.productId AND lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as main_lang', 'main_lang.cId = minor.prevId AND main_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as minor_lang', 'minor_lang.cId = product.cId AND minor_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as base_lang','base_lang.cId = base.categoryId AND base_lang.langId = '.$langId,'left');
            $this->db->join('tb_brand_lang as brand_lang','brand_lang.brandId = brand.brandId AND brand_lang.langId = '.$langId,'left');
            $this->db->join('tb_designer_lang as designer_lang','designer_lang.designerId = designer.designerId AND designer_lang.langId = '.$langId,'left');
        endif;

        return true;
    }
}