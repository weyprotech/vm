<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** Product ********************/
    public function get_product_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        /***** 如果有分類需要加 *****/
        $filter = array(array('field' => 'minor.prevId', 'value' => $this->input->get('mainId', true)), array('field' => 'product.cId', 'value' => $this->input->get('minorId', true)));
        /***** End *****/
        $filter['like'] = array('field' => 'lang.name', 'value' => $search);
        
        $order = array(array('field' => 'product.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('product/tb_product_model', 'product');
        $productList = $this->product->get_product_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->product->count_product($filter, $this->langId);
        if ($productList):
            foreach ($productList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                    'preview' => '<div id="preview">' . (!empty($row->productImg) ? '<img src="' . base_url($row->productImg) . '">' : '') . '</div>',
                    'name' => $row->name,
                    'base_category' => $row->base_category,
                    'sub_category' => $row->sub_category,
                    'order' => $this->get_order('product', $row->productId, $row->order),
                    'action' => $this->get_button('edit', 'backend/product/edit/' . $row->productId . $query) . $this->get_button('delete', 'backend/product/delete/' . $row->productId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    function get_product_order()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('tb_product_model', 'product');

        $minorId = $this->input->get('minorId');
        echo json_encode(array('order' => $this->product->count_product(array(array('field' => 'product.cId', 'value' => $minorId))) + 1));
        return true;
    }
    /******************** End Product ********************/

    /******************** Category ********************/
    function get_category_option($selectId = false)
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('tb_category_model', 'category');

        $name = $this->input->get('type', true);
        $prevId = $this->input->get('prevId', true);
        $categoryList = $this->category->get_category_select(
            array(array('field' => 'category.is_visible', 'value' => 1), array('field' => 'category.prevId', 'value' => $prevId)),
            array(array('field' => 'category.order', 'dir' => 'asc')), false, $this->langId
        );

        $option = array();
        if ($categoryList):
            foreach ($categoryList as $row):
                $option[$row->categoryId] = $row->name;
            endforeach;
        endif;

        echo json_encode(array('select' => form_dropdown($name, $option, $selectId, "id='$name' class='form-control'")));
        return true;
    }
    /******************** End Category ********************/
}