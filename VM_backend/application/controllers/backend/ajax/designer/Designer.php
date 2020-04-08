<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Designer extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('designer/tb_designer_model', 'designer');
        $this->load->model('brand/tb_brand_model','brand');
    }

    /******************** designer ********************/
    public function get_designer_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $country = check_input_value($this->input->get('country',true));
        $query = $this->set_http_query(array('search' => $search));
        /***** Filter *****/
        $filter = array('like' => array('field' => 'lang.name', 'value' => $search),array('field' => 'lang.country','value' => $country));
        /***** Order *****/
        $order = array(array('field' => 'designer.order', 'dir' => 'asc'));

        $designerList = $this->designer->get_designer_select($filter, $order, array('limit' => $limit, 'start' => $start), 3);
        $recordsTotal = $this->designer->count_designer($filter, 3);
        if ($designerList):
            foreach ($designerList as $row):
                $brandList = $this->brand->get_brand_select(array(array('field' => 'brand.designerId','value' => $row->designerId)),false,false);
                if($brandList){
                    $action = $this->get_button('edit', 'backend/designer/designer/edit/' . $row->designerId . $query);
                }else{
                    $action = $this->get_button('edit', 'backend/designer/designer/edit/' . $row->designerId . $query) . $this->get_button('delete', 'backend/designer/designer/delete/' . $row->designerId . $query);
                }
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',
                    'icon' => (!empty($row->designiconImg) ? '<div id="preview"><img src="' . base_url($row->designiconImg) . '"></div>' : ''),
                    'preview' => '<div id="preview">' . (!empty($row->designImg) ? '<img src="' . base_url($row->designImg) . '">' : '') . '</div>',
                    'name' => $row->name,
                    'order' => $this->get_order('designer', $row->designerId, $row->order),
                    'banner' => '<a class="btn btn-warning" href="'.site_url('backend/designer/banner/index/'.$row->designerId).'"><i class="fa fa-picture-o"></i><span class="hidden-mobile"> Banner</span></a>',
                    'post' => '<a class="btn btn-success" href="'.site_url('backend/designer/post/index/'.$row->designerId).'"><i class="fa fa-book"></i><span class="hidden-mobile"> Post</span></button>',
                    'runway' => '<a class="btn btn-primary" href="'.site_url('backend/designer/runway/index/'.$row->designerId).'"><i class="fa fa-clock-o"></i><span class="hidden-mobile"> Runway new event</span></button>',
                    'action' => $action
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    function get_country_option()
    {
        header('Content-Type: application/json; charset=utf-8');

        $selectId = check_input_value($this->input->get('selectId', true), true);
        $option = "";
        $contryList = get_all_country();
        if ($contryList):
            foreach ($contryList as $key => $row):
                $option .= "<option value='$key' " . ($key === $selectId ? "selected" : "") . ">$row</option>";
            endforeach;
        endif;

        echo json_encode(array('option' => $option));
        return true;
    }

    public function check_url(){
        $url = $this->input->post('url',true);
        $id = $this->input->post('id',true);
        if($url == null){
            echo json_encode(array(
                'valid' => false
            ));
        }else{
            if($designerList = $this->designer->get_designer_select(array('other' => array('value' => "designer.url = '$url' and designer.designerId != '$id'")),false,false,3)){
                echo json_encode(array(
                    'valid' => false
                ));
            }else{
                echo json_encode(array(
                    'valid' => true
                ));
            }
        }
    }
    
    public function check_account(){
        $account = $this->input->post('account',true);
        $id = $this->input->post('id',true);
        if($account == null){
            echo json_encode(array(
                'valid' => false
            ));
        }else{
            if($designerList = $this->designer->get_designer_select(array(array('field' => 'designer.account','value' => $account),'other' => array('value' => "designer.designerId != '$id'")),false,false,3)){
                echo json_encode(array(
                    'valid' => false
                ));
            }else{
                echo json_encode(array(
                    'valid' => true
                ));
            }
        }
    }

    public function upload()
    {
        $designerId = $this->input->post('designerId', true);
        if ($designerId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                $config['upload_path'] = 'assets/uploads/designer/designer/';
                $filePath = $this->uploadImg($_FILES['file'], $designerId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }
    /******************** End designer ********************/
}