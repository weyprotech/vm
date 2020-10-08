<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('brand/tb_brand_category_model', 'brand_category');
    }

    /******************** Category ********************/
    public function get_category_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');
        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));

        $query = $this->set_http_query(array('search' => $search));
        /***** Filter *****/
        $filter = array('like' => array('field' => 'lang.name', 'value' => $search));
        /***** Order *****/
        $order = array(array('field' => 'category.create_at', 'dir' => 'asc'));

        $brandCategoryList = $this->brand_category->get_category_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->brand_category->count_category($filter, $this->langId);
        if ($brandCategoryList):
            foreach ($brandCategoryList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                    'img' => (!empty($row->categoryImg) ? '<img src="' . base_url($row->categoryImg) . '">' : ''),
                    'name' => $row->name,                    
                    'action' => $this->get_button('edit', 'backend/brand/category/edit/' . $row->categoryId . $query) . $this->get_button('delete', 'backend/brand/category/delete/' . $row->categoryId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    public function upload()
    {
        $categoryId = $this->input->post('categoryId', true);
        if ($categoryId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                $this->checkUploadPath('brand/category/'); // 上傳路徑
                
                $filePath = $this->uploadImg($_FILES['file'], $categoryId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }

    
    /******************** End category ********************/
}