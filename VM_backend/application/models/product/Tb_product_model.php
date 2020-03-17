<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_product_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->uploadPath .= 'product/';
    }

    /******************** Product Model ********************/
    public function get_product_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_product_join($langId);
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('product.is_enable', 1)->get('tb_product as product');

        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_product($filter = false, $langId = false)
    {
        $this->set_product_join($langId);
        $this->set_filter($filter);
        return $this->db->where('product.is_enable', 1)->count_all_results('tb_product as product');
    }

    public function get_product_by_id($productId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_product_join($langId);
        $this->set_filter(array(array('field' => 'product.is_enable', 'value' => $boolean['enable']), array('field' => 'product.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('product.productId', $productId)->get('tb_product as product');

        if ($query->num_rows() > 0):
            $product = $query->row();
            if (!$langId):
                $product->langList = $this->get_product_lang_select(array(array('field' => 'pId', 'value' => $product->productId)));
            endif;

            return $product;
        endif;

        return false;
    }

    public function insert_product()
    {
        $insert = $this->check_db_data(array('create_at' => date("Y-m-d H:i:s")));

        $this->db->insert('tb_product', $insert);
        return $this->db->insert_id();
    }

    public function update_product($product, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($_FILES['productImg']) && !$_FILES['productImg']['error']):
            $update['productImg'] = $this->uploadFile('product', $product->productId . '/', 300);
            @unlink($product->productImg);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_product_lang($product->productId, $post['langList']);
        endif;

        $this->db->update('tb_product', $update, array('productId' => $product->productId));
        return true;
    }

    public function delete_product($product)
    {
        $this->update_product($product, array('is_enable' => 0));
        $this->db->update('tb_product_image', $this->check_db_data(array('is_enable' => 0)), array('prevId' => $product->productId));
        return $this->reorder_product($product->cId);
    }

    /*************** 重新排序 ***************/
    private function reorder_product($cId)
    {
        $result = $this->get_product_select(array(array('field' => 'product.cId', 'value' => $cId)), array(array('field' => 'product.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('productId' => $row->productId, 'order' => $i + 1));
            endforeach;

            return $this->db->update_batch('tb_product', $order, 'productId');
        endif;

        return true;
    }

    /*************** Product Lang Model ***************/
    private function get_product_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_product_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_product_lang($productId, $update)
    {
        $this->db->where('pId', $productId)->update_batch('tb_product_lang', $update, 'langId');

        $langList = $this->get_product_lang_select(array(array('field' => 'pId', 'value' => $productId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_product_lang', $insert);
        endif;

        return true;
    }
    /*************** End Product Lang Model ***************/
    /******************** End Product Model ********************/

    /*************** Product Image Model ***************/
    public function get_product_image_select($filter = false, $order = false, $limit = false)
    {
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('image.is_enable', 1)->get('tb_product_image as image');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_product_image($filter = false)
    {
        $this->set_filter($filter);
        return $this->db->where('image.is_enable', 1)->count_all_results('tb_product_image as image');
    }

    public function get_product_image_by_id($imageId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_filter(array(array('field' => 'image.is_enable', 'value' => $boolean['enable']), array('field' => 'image.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('image.imageId', $imageId)->get('tb_product_image as image');
        if ($query->num_rows() > 0):
            return $query->row();
        endif;

        return false;
    }

    public function insert_product_image($prevId)
    {
        $insert = $this->check_db_data(array(
            'prevId' => $prevId,
            'order' => $this->count_product_image(array(array('field' => 'image.prevId', 'value' => $prevId))) + 1,
            'create_at' => date("Y-m-d H:i:s")
        ));

        $this->db->insert('tb_product_image', $insert);
        return $this->db->insert_id();
    }

    public function update_product_image($image, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($_FILES['photoImg']) && !$_FILES['photoImg']['error']):
            $update['imagePath'] = $this->uploadFile('photo', $image->prevId . '/');
            @unlink($image->imagePath);

            // 如果不需要另外上傳縮圖，可直接在這使用 //
            // $update['thumbPath'] = $this->uploadFile('photo', $image->prevId . '/', 300);
            // @unlink($image->thumbPath);
        endif;

        // 如果需要另外上傳縮圖，可在這使用 //
        if (isset($_FILES['thumbImg']) && !$_FILES['thumbImg']['error']):
            $update['thumbPath'] = $this->uploadFile('thumb', $image->prevId . '/', 300);
            @unlink($image->thumbPath);
        endif;

        return $this->db->update('tb_product_image', $update, array('imageId' => $image->imageId));
    }

    public function delete_product_image($image)
    {
        $this->update_product_image($image, $this->check_db_data(array('is_enable' => 0)));
        return $this->reorder_product_image($image->prevId);
    }

    /*************** 重新排序 ***************/
    public function reorder_product_image($prevId)
    {
        $result = $this->get_product_image_select(array(array('field' => 'image.prevId', 'value' => $prevId)), array(array('field' => 'image.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('imageId' => $row->imageId, 'order' => $i + 1));
            endforeach;

            return $this->db->update_batch('tb_product_image', $order, 'imageId');
        endif;

        return true;
    }
    /*************** End Product Image Model ***************/
    /******************** End Product Model ********************/

    /******************** Private Function ********************/
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('mainId', 'imageOrder', 'langList', 'uuid'))):
                switch ($field):
                    case 'minorId':
                        $data['cId'] = check_input_value($value, true);
                        break;

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'productId', 'cId', 'pId', /* Product Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }

    private function set_product_join($langId)
    {
        $this->db->select('product.*, minor.prevId as mainId, product.cId as minorId');
        $this->db->join('tb_product_category as minor', 'minor.categoryId = product.cId AND minor.is_enable', 'left');
        $this->db->join('tb_product_category as main', 'main.categoryId = minor.prevId AND main.is_enable', 'left');
        if ($langId):
            $this->db->select('lang.*, main_lang.name as mainName, minor_lang.name as minorName');
            $this->db->join('tb_product_lang as lang', 'lang.pId = product.productId AND lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as main_lang', 'main_lang.cId = minor.prevId AND main_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as minor_lang', 'minor_lang.cId = product.cId AND minor_lang.langId = ' . $langId, 'left');
        endif;

        return true;
    }
    /******************** End Private Function ********************/
}