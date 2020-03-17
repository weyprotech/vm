<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category extends Ajax_Controller
{
    private $lv = 2; // 設訂總共有多少層類別

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** Category ********************/
    public function get_category_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('product/tb_category_model', 'category');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $cId = $this->input->get('cId',true);
        $firstId = check_input_value($this->input->get('firstId',true),true,0);
        $secondId = check_input_value($this->input->get('secondId', true), true, 0);
        $search = check_input_value($this->input->get('search[value]', true));
        if($secondId == '' || $secondId == 0){
            $prevId = $firstId;
        }else{
            if($firstId == ''){
                $prevId = 0;
            }else{
                $prevId = $secondId;                
            }
        }
        $filter = array(array('field' => 'category.prevId', 'value' => $prevId), 'like' => array('field' => 'lang.name', 'value' => $search));
        $order = array(array('field' => 'category.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('prevId' => $prevId, 'search' => $search));

        $categoryList = $this->category->get_category_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->category->count_category($filter);
        $prevList = $this->category->get_category_select(false,$order,array());
        if ($categoryList):
            foreach ($categoryList as $row):
                $basecategory = '';
                $subcategory = '';
                if($row->lv == 3){
                    foreach($prevList as $prevKey => $prevValue){
                        if($row->prev_categoryId == $prevValue->categoryId){
                            $basecategory = $this->category->get_category_by_id($prevValue->prevId);                        
                        }
                    }
                }

                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                    'preview' => '<div id="preview">' . (!empty($row->categoryImg) ? '<img src="' . base_url($row->categoryImg) . '">' : '') . '</div>',
                    'name' => $row->name,
                    'prevName' => check_input_value($row->prevName, false, "無"),

                    'lv' => $row->lv != $this->lv ? $this->get_button('level', $row->categoryId) : '無',
                    'order' => $this->get_order('category', $row->categoryId, $row->order),
                    'action' => $this->get_button('edit', 'backend/product/category/edit/' . $row->categoryId . $query) . $this->get_button('delete', 'backend/product/category/delete/' . $row->categoryId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    public function get_category_prevId()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('product/tb_category_model', 'category');

        $prevId = 0;
        $categoryId = $this->input->get('categoryId', true);
        if ($category = $this->category->get_category_by_id($categoryId, $this->langId)):
            $prevId = $category->prevId;
        endif;

        echo json_encode(array('prevId' => $prevId));
        return true;
    }

    public function get_first_option(){
        $this->load->model('product/tb_category_model', 'category');

        $firstList = $this->category->get_category_select(array(array('field' => 'category.lv','value' => 1)),false,false,3);
        $selectId = $this->input->get('selectId',true);
        $option = '';
        if($firstList){
            foreach($firstList as $firstKey => $firstValue){
                $option .= '<option value="'.$firstValue->categoryId.'" '.($firstValue->categoryId == $selectId ? 'selected':'').'>'.$firstValue->name.'</option>';
            }
        }
        echo json_encode(array('option' => $option));
    }

    public function get_category_option(){
        $selected = $this->input->get('selected',true);
        $cId = $this->input->get('cId',true) === '' ? false:$this->input->get('cId',true);
        $this->load->model('product/tb_category_model', 'category');
        if($this->input->get('cId',true) != ''){
            $categoryList = $this->category->get_category_select(array(array('field' => 'category.prevId','value' => $cId)),false,false,3);
            $option = '<option value=0>None</option>';
            if($categoryList){
                foreach($categoryList as $categoryKey => $categoryValue){
                    $option .= '<option value="'.$categoryValue->categoryId.'" '.($selected == $categoryValue->categoryId ? 'checked' : '').'>'.$categoryValue->name.'</option>';
                }
            }
            echo json_encode(array('option' => $option));

        }else{
            echo json_encode(array('option' => ''));
        }

    }
    /******************** End Category ********************/
}