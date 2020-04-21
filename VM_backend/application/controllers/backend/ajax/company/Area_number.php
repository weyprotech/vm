<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Area_number extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** area_number ********************/
    public function get_area_number_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $this->load->model('company/tb_area_number_model', 'area_number');        

        $filter['like'] = array('field' => 'lang.area', 'value' => $search);

        $order = array(array('field' => 'area_number.order', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));
        
        $areaList = $this->area_number->get_area_number_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->area_number->count_area_number($filter,$this->langId);

        if ($areaList):
            foreach ($areaList as $row):
                $data[] = array(                    
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                    
                    'area' => $row->area,
                    'number' => $row->number,                                        
                    'action' => $this->get_button('edit', 'backend/company/area_number/edit/' . $row->Id . $query) . $this->get_button('delete', 'backend/company/area_number/delete/' . $row->Id . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    function get_area_number_order()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('tb_area_number_model', 'area_number');

        $minorId = $this->input->get('minorId');
        echo json_encode(array('order' => $this->area_number->count_area_number(array(array('field' => 'area_number.cId', 'value' => $minorId))) + 1));
        return true;
    }
    /******************** End area_number ********************/
    /******************** area_number image ******************/
    public function get_area_number_img($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $area_numberId = check_input_value($this->input->get('area_numberId',true));

        $filter = array(array('field' => 'area_number_img.pId', 'value' => $area_numberId));
        $order = array(array('field' => 'area_number_img.order', 'dir' => 'desc'));

        $this->load->model('area_number/tb_area_number_model', 'area_number_model');
        $area_numberList = $this->area_number_model->get_area_number_img_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->area_number_model->count_area_number_img($filter, $this->langId);
        if ($area_numberList):
            foreach ($area_numberList as $row):
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
        $area_numberId = $post['area_numberId'];
        $Id = $post['Id'];
        $youtube = $post['youtube'];
        $file = 'area_number/area_number/'.$area_numberId;        
        $filePath = '';
        $this->load->model('area_number/tb_area_number_model', 'area_number_model');

        if($_FILES){
            if (!is_dir($this->uploadPath .= $file.'/')) mkdir($this->uploadPath, 0777,true);
            $config['upload_path'] = 'assets/uploads/'.$file.'/';
            $small_file = $this->uploadImg($_FILES['small_file'],'/',300);
            $middle_file = $this->uploadImg($_FILES['middle_file'],'/',470);
            $big_file = $this->uploadImg($_FILES['big_file'],'/',600);

            if($Id == 'new'){
                $this->area_number_model->insert_area_number_img(array('small_thumbPath' => $small_file['thumbPath'],'small_imagePath' => $small_file['imagePath'],'middle_thumbPath' => $middle_file['thumbPath'],'middle_imagePath' => $middle_file['imagePath'],'big_thumbPath' => $big_file['thumbPath'],'big_imagePath' => $big_file['imagePath'],'pId' => $area_numberId,'youtube' => $youtube));
            }else{
                $old_file = $this->area_number_model->get_area_number_img_by_id($Id);
                $this->area_number_model->update_area_number_img($old_file,array('small_thumbPath' => $small_file['thumbPath'],'small_imagePath' => $small_file['imagePath'],'middle_thumbPath' => $middle_file['thumbPath'],'middle_imagePath' => $middle_file['imagePath'],'big_thumbPath' => $big_file['thumbPath'],'big_imagePath' => $big_file['imagePath'],'pId' => $area_numberId,'youtube' => $youtube));
            }
        }else{
            $old_file = $this->area_number_model->get_area_number_img_by_id($Id);
            $this->area_number_model->update_area_number_img($old_file,array('pId' => $area_numberId,'youtube' => $youtube));
        }
        echo json_encode(array('status' => true));
        return true;
    }

    public function upload()
    {
        $area_numberId = $this->input->post('area_numberId', true);
        if ($area_numberId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                $this->uploadPath = 'assets/uploads/area_number/area_number/';
                $filePath = $this->uploadImg($_FILES['file'], $area_numberId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }

    public function delete_img(){
        $this->load->model('area_number/tb_area_number_model', 'area_number_model');

        $Id = $this->input->post('Id',true);
        $old_file = $this->area_number_model->get_area_number_img_by_id($Id);
        $this->area_number_model->delete_area_number_img($old_file);
        echo json_encode(array('status' => true));
        return true;
    }
    /************** End area_number img *******************/

    /************** Start area_number color **********/
    public function get_area_number_color($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $area_numberId = check_input_value($this->input->get('area_numberId',true));

        $filter = array(array('field' => 'area_number_color.pId', 'value' => $area_numberId));
        $order = array(array('field' => 'area_number_color.order', 'dir' => 'asc'));

        $this->load->model('area_number/tb_area_number_model', 'area_number_model');
        $area_numberList = $this->area_number_model->get_area_number_color_select($filter, $order, array('limit' => $limit, 'start' => $start), 3);
        $recordsTotal = $this->area_number_model->count_area_number_color($filter, $this->langId);
        if ($area_numberList):
            foreach ($area_numberList as $row):
                $data[] = array(  
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                    
                    'color' => $row->color,
                    'action' => $this->get_button('edit', 'backend/area_number/color/edit/' . $row->colorId) . $this->get_button('delete', 'backend/area_number/color/delete/' . $row->colorId.'/'.$row->pId)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
}