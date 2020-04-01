<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Runway extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }


    /**** 快閃活動圖片 ****/
    public function get_runway_img($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $runwayId = check_input_value($this->input->get('runwayId',true));

        $filter = array(array('field' => 'runway_img.runwayId', 'value' => $runwayId));
        $order = array(array('field' => 'runway_img.order', 'dir' => 'asc'));

        $this->load->model('designer/tb_runway_model', 'runway');
        $runwayList = $this->runway->get_runway_img_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->runway->count_runway_img($filter, $this->langId);
        if ($runwayList):
            foreach ($runwayList as $row):
                $data[] = array(
                    'preview' => '<div id="preview">' . (!empty($row->runwayImg) ? '<img src="' . base_url($row->runwayImg) . '" width="100%">' : '') . '</div>',
                    'youtube' => $row->youtube,
                    'action' => '<button type="button" class="btn btn-primary" onclick="imgUpload(\''.$row->Id.'\')"><i class="fa fa-gear"></i><span class="hidden-mobile"> Edit</span></button>'.'<button type="button" class="btn btn-danger" onclick="delete_imgList(\''.$row->Id.'\')"><i class="glyphicon glyphicon-trash"></i><span class="hidden-mobile"> Delete</span></button>'
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    
    public function upload_img(){
        $post = $this->input->post(null,true);
        $runwayId = $post['runwayId'];
        $Id = $post['Id'];
        $youtube = $post['youtube'];
        $this->checkUploadPath('designer/runway/'); // 上傳路徑
        $this->load->model('designer/tb_runway_model', 'runway_model');

        if($_FILES){
            // if (!is_dir($this->uploadPath .= $file.'/')) mkdir($this->uploadPath, 0777,true);
            foreach ($_FILES as $key => $value) {
                // $config['upload_path'] = 'assets/uploads/'.$file.'/';
                $file = $this->uploadImg($_FILES[0],$runwayId.'/',685);
                
                if($Id == 'new'){                    
                    $this->runway_model->insert_runway_img(array('runwayImg' => $file['thumbPath'],'runwayId' => $runwayId,'youtube' => $youtube));
                }else{
                    $old_file = $this->runway_model->get_runway_img_by_id($Id);
                    $this->runway_model->update_runway_img_select($old_file,array('runwayImg' => $file['thumbPath'],'runwayId' => $runwayId,'youtube' => $youtube));
                }      
            }     
        }else{
            $old_file = $this->runway_model->get_runway_img_by_id($Id);
            $this->runway_model->update_runway_img_select($old_file,array('runwayId' => $runwayId,'youtube' => $youtube));
        }
        echo json_encode(array('status' => true));
        return true;
    }

    public function delete_img(){
        $this->load->model('designer/tb_runway_model', 'runway_model');

        $Id = $this->input->post('Id',true);
        $old_file = $this->runway_model->get_runway_img_by_id($Id);
        $this->runway_model->delete_runway_img($old_file);
        echo json_encode(array('status' => true));
        return true;
    }

    public function upload()
    {
        $this->checkUploadPath('designer/runway/'); // 上傳路徑

        $runwayId = $this->input->post('runwayId', true);
        if ($runwayId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                // $this->uploadPath = 'assets/uploads/designer/runway/'.$runwayId;
                $filePath = $this->uploadImg($_FILES['file'], $runwayId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }
    /******************** End runway ********************/
}