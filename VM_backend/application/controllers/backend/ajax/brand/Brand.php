<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('brand/tb_brand_model', 'brand');
    }

    /******************** brand ********************/
    public function get_brand_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $country = check_input_value($this->input->get('country',true));
        $query = $this->set_http_query(array('search' => $search));
        /***** Filter *****/
        $filter = array('like' => array('field' => 'lang.name', 'value' => $search),array('field' => 'brand.country','value' => $country));
        /***** Order *****/
        $order = array(array('field' => 'brand.order', 'dir' => 'asc'));

        $brandList = $this->brand->get_brand_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->brand->count_brand($filter, $this->langId);
        if ($brandList):
            foreach ($brandList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                    'icon' => (!empty($row->brandiconImg) ? '<img src="' . base_url($row->brandiconImg) . '">' : ''),
                    'preview' => '<div id="preview">' . (!empty($row->brandImg) ? '<img src="' . base_url($row->brandImg) . '">' : '') . '</div>',
                    'name' => $row->name,
                    'order' => $this->get_order('brand', $row->brandId, $row->order),
                    'banner' => '<a class="btn btn-warning" href="'.site_url('backend/brand/banner/index/'.$row->brandId).'"><i class="fa fa-picture-o"></i><span class="hidden-mobile"> Banner</span></a>',
                    'message' => '<a class="btn bg-color-redLight" href="'.site_url('backend/brand/message/index/'.$row->brandId).'" style="color:white"><i class="fa fa-comments"></i><span class="hidden-mobile" style="color:white"> Message</span></a>',

                    // 'post' => '<a class="btn btn-success" href="'.site_url('backend/brand/post/index/'.$row->brandId).'"><i class="fa fa-book"></i><span class="hidden-mobile"> Post</span></button>',
                    'action' => $this->get_button('edit', 'backend/brand/brand/edit/' . $row->brandId . $query) . $this->get_button('delete', 'backend/brand/brand/delete/' . $row->brandId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    public function upload()
    {
        $brandId = $this->input->post('brandId', true);
        if ($brandId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                $this->checkUploadPath('brand/brand/'); // 上傳路徑
                
                $filePath = $this->uploadImg($_FILES['file'], $brandId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }

    
    /******************** End brand ********************/
}