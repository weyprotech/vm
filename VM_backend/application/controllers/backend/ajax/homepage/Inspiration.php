<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inspiration extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** inspiration ********************/
    public function get_inspiration_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));        
        $filter = array('like' => array('field' => 'lang.title', 'value' => $search));
        $order = array(array('field' => 'inspiration.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('homepage/tb_inspiration_model', 'inspiration');
        $inspirationList = $this->inspiration->get_inspiration_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->inspiration->count_inspiration($filter, $this->langId);
        if ($inspirationList):
            foreach ($inspirationList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                
                    'preview' => '<div id="preview">' . (!empty($row->inspirationImg) ? '<img src="' . base_url($row->inspirationImg) . '" width="200px">' : '') . '</div>',
                    'title' => $row->title,
                    'order' => $this->get_order('inspiration', $row->inspirationId, $row->order),
                    'message' => '<a class="btn btn-success" href="'.site_url('backend/homepage/inspiration/message/' . $row->inspirationId).'"><i class="fa fa-paper-plane"></i><span class="hidden-mobile"> Message</span></a>',
                    'action' => $this->get_button('edit', 'backend/homepage/inspiration/edit/' . $row->inspirationId . $query) . $this->get_button('delete', 'backend/homepage/inspiration/delete/' . $row->inspirationId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    /******************** inspiration_message ********************/
    public function get_inspiration_message_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');
        $inspirationId = $this->input->get('inspirationId', true);
        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));        
        $filter = array('like' => array('field' => 'message.message', 'value' => $search), array('field' => 'message.inspirationId', 'value' => $inspirationId));
        $order = array(array('field' => 'message.create_at', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('homepage/tb_inspiration_message_model', 'inspiration_message');
        $inspiration_messageList = $this->inspiration_message->get_inspiration_message_select($filter, $order, array('limit' => $limit, 'start' => $start));
        $recordsTotal = $this->inspiration_message->count_inspiration_message($filter);
        if ($inspiration_messageList):
            foreach ($inspiration_messageList as $row):
                $data[] = array(
                    'message' => $row->message,
                    'action' => $this->get_button('edit', 'backend/homepage/inspiration/message_edit/'. $inspirationId . '/' . $row->Id . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    //取得不是該穿搭裡的產品
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
        $inspirationId = $this->input->post('inspirationId',true);
        $this->load->model('homepage/tb_inspiration_model','inspiration_model');
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
                if(!$inspirationList = $this->inspiration_model->get_inspiration_related_product_select(array(array('field' => 'relate_product.pId','value' => $row->productId),array('field' =>'relate_product.iId','value' => $inspirationId)),false,false,3)){
                    $data[] = array(
                        'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                        'preview' => '<div id="preview">' . (!empty($row->productImg) ? '<img src="' . base_url($row->productImg) . '">' : '') . '</div>',
                        'name' => $row->name,
                        'base_category' => $row->baseName,
                        'sub_category' => $row->mainName,
                        'category' => $row->minorName,
                        'action' => '<button class="btn btn-primary add_product" type="button" data-id="'.$row->productId.'" data-img="'.$row->productImg.'" data-name="' . $row->name . '" data-base_category="'.$row->baseName.'" data-sub_category="'.$row->mainName.'" data-category="'.$row->minorName.'"><i class="fa fa-plus" style="color:white"></i> <span style="color:white">Add</span></button>',
                    );
                }

            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    public function upload()
    {
        $this->checkUploadPath('homepage/inspiration/'); // 上傳路徑

        $inspirationId = $this->input->post('inspirationId', true);
        if ($inspirationId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                // $this->uploadPath = 'assets/uploads/homepage/inspiration/';
                $filePath = $this->uploadImg($_FILES['file'], $inspirationId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }
}