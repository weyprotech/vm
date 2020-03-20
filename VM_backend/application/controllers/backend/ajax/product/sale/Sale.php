<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sale extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    //取得目前特價產品
    public function get_sale_product($data = array()){
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $baseId = $this->input->post('baseId',true);
        $subId = $this->input->post('subId',true);
        $categoryId = $this->input->post('categoryId',true);
        $this->load->model('product/tb_sale_model', 'sale_model');
        $this->load->model('product/tb_category_model','category');
        
        $baseCategory = $this->category->get_category_by_id($baseId);
        $subCategory = $this->category->get_category_by_id($subId);
        $category = $this->category->get_category_by_id($categoryId);
        $sale_main = $this->sale_model->get_sale_information();

        if($categoryId != '' && $categoryId != 0 && $category->prevId == $subCategory->categoryId && $subCategory->prevId == $baseCategory->categoryId){
            $filter = array(array('field' => 'product.cId', 'value' => $categoryId));
        }else if($subId != '' && $subId != 0 && $subCategory->prevId == $baseCategory->categoryId){            
            $filter = array(array('field' => 'main.categoryId','value' => $subId));
        }else if($baseId != '' && $baseId != 0){
            $filter = array(array('field' => 'base.categoryId','value' => $baseId));
        }

        $filter['like'] = array('field' => 'lang.name', 'value' => $search);
        
        $order = array(array('field' => 'product.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        
        $productList = $this->sale_model->get_sale_product_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->sale_model->count_sale_product($filter, $this->langId);

        if ($productList):
            foreach ($productList as $row):
                $data[] = array(           
                    'preview' => '<div id="preview">' . (!empty($row->productImg) ? '<img src="' . base_url($row->productImg) . '">' : '') . '</div>',
                    'name' => $row->name,
                    'base_category' => $row->baseName,
                    'sub_category' => $row->mainName,
                    'category' => $row->minorName,
                    'original_price' => $row->original_price,
                    'special_offer' => (($row->original_price)-($row->original_price*($sale_main->discount/100))),
                    'action' => $this->get_button('delete', 'backend/product/sale/sale_product/delete/' . $row->Id . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    

    //取得沒有特價產品
    /******************** Product ********************/
    public function get_product_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $baseId = $this->input->post('baseId',true);
        $subId = $this->input->post('subId',true);
        $categoryId = $this->input->post('categoryId',true);
        $this->load->model('product/tb_sale_model', 'sale_model');
        $this->load->model('product/tb_product_model', 'product');
        $this->load->model('product/tb_category_model','category');

        $baseCategory = $this->category->get_category_by_id($baseId);
        $subCategory = $this->category->get_category_by_id($subId);
        $category = $this->category->get_category_by_id($categoryId);

        if($categoryId != '' && $categoryId != 0 && $category->prevId == $subCategory->categoryId && $subCategory->prevId == $baseCategory->categoryId){
            $filter = array(array('field' => 'product.cId', 'value' => $categoryId));
        }else if($subId != '' && $subId != 0 && $subCategory->prevId == $baseCategory->categoryId){            
            $filter = array(array('field' => 'main.categoryId','value' => $subId));
        }else if($baseId != '' && $baseId != 0){
            $filter = array(array('field' => 'base.categoryId','value' => $baseId));
        }

        $filter['like'] = array('field' => 'lang.name', 'value' => $search);
        
        $order = array(array('field' => 'product.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        
        $productList = $this->product->get_product_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->product->count_product($filter, $this->langId);

        if ($productList):
            foreach ($productList as $row):
                if(!$sale = $this->sale_model->get_sale_product_by_pId($row->productId)){
                    $data[] = array(
                        'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                        'preview' => '<div id="preview">' . (!empty($row->productImg) ? '<img src="' . base_url($row->productImg) . '">' : '') . '</div>',
                        'name' => $row->name,
                        'base_category' => $row->baseName,
                        'sub_category' => $row->mainName,
                        'category' => $row->minorName,
                        'action' => '<button class="btn btn-primary" type="button" onclick="select_product(\''.$row->productId.'\')"><i class="fa fa-plus" style="color:white"></i> <span style="color:white">Add</span></button>',
                    );
                }

            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    //新增特價商品
    public function add_product(){
        $productId = $this->input->post('productId',true);
        $this->load->model('product/tb_sale_model', 'sale_model');
        $this->sale_model->insert_sale_product(array('pId' => $productId));
        echo json_encode(array('status' => 1));
        return true;
    }
}