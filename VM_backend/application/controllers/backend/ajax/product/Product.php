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

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $baseId = $this->input->post('baseId',true);
        $subId = $this->input->post('subId',true);
        $categoryId = $this->input->post('categoryId',true);
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
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                    'preview' => '<div id="preview">' . (!empty($row->productImg) ? '<img src="' . base_url($row->productImg) . '">' : '') . '</div>',
                    'name' => $row->name,
                    'base_category' => $row->baseName,
                    'sub_category' => $row->mainName,
                    'category' => $row->minorName,
                    'price' => $row->price,
                    'color' => '<a class="btn btn-primary" href="'.site_url('backend/product/color/index/'.$row->productId).'"><i class="fa fa-dashboard"></i><span class="hidden-mobile"> Color</span></button>',                
                    'manufacture' => '<a class="btn btn-success" href="'.site_url('backend/product/manufacture/edit/'.$row->productId).'"><i class="fa fa-home"></i><span class="hidden-mobile"> Manufacture</span></button>',
                    'fabric' => '<a class="btn btn-success" href="'.site_url('backend/product/fabric/edit/'.$row->productId).'"><i class="fa fa-slack"></i><span class="hidden-mobile"> Fabric</span></button>',
                    'review' => '<a class="btn btn-warning" href="javascript:;"><i class="fa fa-weixin"></i><span class="hidden-mobile"> Reviews</span></button>',
                    'order' => $this->get_order('product', $row->productId, $row->order),
                    'action' => $this->get_button('edit', 'backend/product/product/edit/' . $row->productId . $query) . $this->get_button('delete', 'backend/product/product/delete/' . $row->productId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
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
    /******************** Product image ******************/
    public function get_product_img($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $productId = check_input_value($this->input->get('productId',true));

        $filter = array(array('field' => 'product_img.pId', 'value' => $productId));
        $order = array(array('field' => 'product_img.order', 'dir' => 'desc'));

        $this->load->model('product/tb_product_model', 'product_model');
        $productList = $this->product_model->get_product_img_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->product_model->count_product_img($filter, $this->langId);
        if ($productList):
            foreach ($productList as $row):
                $data[] = array(
                    'small' => '<div id="preview">' . (!empty($row->small_thumbPath) ? '<img src="' . base_url($row->small_thumbPath) . '" style="width:100px">' : '') . '</div>',
                    'middle' => '<div id="preview">' . (!empty($row->middle_thumbPath) ? '<img src="' . base_url($row->middle_thumbPath) . '" style="width:100px">' : '') . '</div>',
                    'big' => '<div id="preview">' . (!empty($row->big_thumbPath) ? '<img src="' . base_url($row->big_thumbPath) . '" style="width:100px">' : '') . '</div>',
                    'youtube' => $row->youtube,
                    'order' => $this->get_order('image', $row->imageId, $row->order),
                    'action' => '<button type="button" class="btn btn-primary" onclick="imgUpload(\''.$row->imageId.'\')"><i class="fa fa-gear"></i><span class="hidden-mobile"> Edit</span></button>'.'<button type="button" class="btn btn-danger" onclick="delete_imgList(\''.$row->imageId.'\')"><i class="glyphicon glyphicon-trash"></i><span class="hidden-mobile"> Delete</span></button>'
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    
    public function upload_img(){
        $post = $this->input->post(null,true);
        $productId = $post['productId'];
        $Id = $post['Id'];
        $youtube = $post['youtube'];
        $file = 'product/product/'.$productId;        
        $filePath = '';
        $this->load->model('product/tb_product_model', 'product_model');

        if($_FILES){
            if (!is_dir($this->uploadPath .= $file.'/')) mkdir($this->uploadPath, 0777,true);
            $config['upload_path'] = 'assets/uploads/'.$file.'/';
            $small_file = $this->uploadImg($_FILES['small_file'],'/',300);
            $middle_file = $this->uploadImg($_FILES['middle_file'],'/',470);
            $big_file = $this->uploadImg($_FILES['big_file'],'/',600);

            if($Id == 'new'){
                $this->product_model->insert_product_img(array('small_thumbPath' => $small_file['thumbPath'],'small_imagePath' => $small_file['imagePath'],'middle_thumbPath' => $middle_file['thumbPath'],'middle_imagePath' => $middle_file['imagePath'],'big_thumbPath' => $big_file['thumbPath'],'big_imagePath' => $big_file['imagePath'],'pId' => $productId,'youtube' => $youtube));
            }else{
                $old_file = $this->product_model->get_product_img_by_id($Id);
                $this->product_model->update_product_img($old_file,array('small_thumbPath' => $small_file['thumbPath'],'small_imagePath' => $small_file['imagePath'],'middle_thumbPath' => $middle_file['thumbPath'],'middle_imagePath' => $middle_file['imagePath'],'big_thumbPath' => $big_file['thumbPath'],'big_imagePath' => $big_file['imagePath'],'pId' => $productId,'youtube' => $youtube));
            }
        }else{
            $old_file = $this->product_model->get_product_img_by_id($Id);
            $this->product_model->update_product_img($old_file,array('pId' => $productId,'youtube' => $youtube));
        }
        echo json_encode(array('status' => true));
        return true;
    }

    public function upload()
    {
        $productId = $this->input->post('productId', true);
        if ($productId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                $this->uploadPath = 'assets/uploads/product/product/';
                $filePath = $this->uploadImg($_FILES['file'], $productId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }

    public function delete_img(){
        $this->load->model('product/tb_product_model', 'product_model');

        $Id = $this->input->post('Id',true);
        $old_file = $this->product_model->get_product_img_by_id($Id);
        $this->product_model->delete_product_img($old_file);
        echo json_encode(array('status' => true));
        return true;
    }
    /************** End Product img *******************/

    /************** Start Product color **********/
    public function get_product_color($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $productId = check_input_value($this->input->get('productId',true));

        $filter = array(array('field' => 'product_color.pId', 'value' => $productId));
        $order = array(array('field' => 'product_color.order', 'dir' => 'asc'));

        $this->load->model('product/tb_product_model', 'product_model');
        $productList = $this->product_model->get_product_color_select($filter, $order, array('limit' => $limit, 'start' => $start), 3);
        $recordsTotal = $this->product_model->count_product_color($filter, $this->langId);
        if ($productList):
            foreach ($productList as $row):
                $data[] = array(  
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                    
                    'color' => $row->color,
                    'action' => $this->get_button('edit', 'backend/product/color/edit/' . $row->colorId) . $this->get_button('delete', 'backend/product/color/delete/' . $row->colorId.'/'.$row->pId)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
}