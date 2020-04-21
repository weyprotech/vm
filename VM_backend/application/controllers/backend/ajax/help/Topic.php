<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Topic extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** topic ********************/
    public function get_topic_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $this->load->model('help/tb_topic_model', 'topic');        

        $filter['like'] = array('field' => 'lang.topic', 'value' => $search);

        $order = array(array('field' => 'topic.order', 'dir' => 'desc'));
        $query = $this->set_http_query(array('search' => $search));
        
        $topicList = $this->topic->get_topic_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->topic->count_topic($filter,$this->langId);

        if ($topicList):
            foreach ($topicList as $row):
                $data[] = array(                    
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                    
                    'topic' => $row->topic,
                    'action' => $this->get_button('edit', 'backend/help/topic/edit/' . $row->topicId . $query) . $this->get_button('delete', 'backend/help/topic/delete/' . $row->topicId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    function get_topic_order()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('tb_topic_model', 'topic');

        $minorId = $this->input->get('minorId');
        echo json_encode(array('order' => $this->topic->count_topic(array(array('field' => 'topic.cId', 'value' => $minorId))) + 1));
        return true;
    }
    /******************** End topic ********************/
    /******************** topic image ******************/
    public function get_topic_img($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $topicId = check_input_value($this->input->get('topicId',true));

        $filter = array(array('field' => 'topic_img.pId', 'value' => $topicId));
        $order = array(array('field' => 'topic_img.order', 'dir' => 'desc'));

        $this->load->model('topic/tb_topic_model', 'topic_model');
        $topicList = $this->topic_model->get_topic_img_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->topic_model->count_topic_img($filter, $this->langId);
        if ($topicList):
            foreach ($topicList as $row):
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
        $topicId = $post['topicId'];
        $Id = $post['Id'];
        $youtube = $post['youtube'];
        $file = 'topic/topic/'.$topicId;        
        $filePath = '';
        $this->load->model('topic/tb_topic_model', 'topic_model');

        if($_FILES){
            if (!is_dir($this->uploadPath .= $file.'/')) mkdir($this->uploadPath, 0777,true);
            $config['upload_path'] = 'assets/uploads/'.$file.'/';
            $small_file = $this->uploadImg($_FILES['small_file'],'/',300);
            $middle_file = $this->uploadImg($_FILES['middle_file'],'/',470);
            $big_file = $this->uploadImg($_FILES['big_file'],'/',600);

            if($Id == 'new'){
                $this->topic_model->insert_topic_img(array('small_thumbPath' => $small_file['thumbPath'],'small_imagePath' => $small_file['imagePath'],'middle_thumbPath' => $middle_file['thumbPath'],'middle_imagePath' => $middle_file['imagePath'],'big_thumbPath' => $big_file['thumbPath'],'big_imagePath' => $big_file['imagePath'],'pId' => $topicId,'youtube' => $youtube));
            }else{
                $old_file = $this->topic_model->get_topic_img_by_id($Id);
                $this->topic_model->update_topic_img($old_file,array('small_thumbPath' => $small_file['thumbPath'],'small_imagePath' => $small_file['imagePath'],'middle_thumbPath' => $middle_file['thumbPath'],'middle_imagePath' => $middle_file['imagePath'],'big_thumbPath' => $big_file['thumbPath'],'big_imagePath' => $big_file['imagePath'],'pId' => $topicId,'youtube' => $youtube));
            }
        }else{
            $old_file = $this->topic_model->get_topic_img_by_id($Id);
            $this->topic_model->update_topic_img($old_file,array('pId' => $topicId,'youtube' => $youtube));
        }
        echo json_encode(array('status' => true));
        return true;
    }

    public function upload()
    {
        $topicId = $this->input->post('topicId', true);
        if ($topicId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                $this->uploadPath = 'assets/uploads/topic/topic/';
                $filePath = $this->uploadImg($_FILES['file'], $topicId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }

    public function delete_img(){
        $this->load->model('topic/tb_topic_model', 'topic_model');

        $Id = $this->input->post('Id',true);
        $old_file = $this->topic_model->get_topic_img_by_id($Id);
        $this->topic_model->delete_topic_img($old_file);
        echo json_encode(array('status' => true));
        return true;
    }
    /************** End topic img *******************/

    /************** Start topic color **********/
    public function get_topic_color($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $topicId = check_input_value($this->input->get('topicId',true));

        $filter = array(array('field' => 'topic_color.pId', 'value' => $topicId));
        $order = array(array('field' => 'topic_color.order', 'dir' => 'asc'));

        $this->load->model('topic/tb_topic_model', 'topic_model');
        $topicList = $this->topic_model->get_topic_color_select($filter, $order, array('limit' => $limit, 'start' => $start), 3);
        $recordsTotal = $this->topic_model->count_topic_color($filter, $this->langId);
        if ($topicList):
            foreach ($topicList as $row):
                $data[] = array(  
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                    
                    'color' => $row->color,
                    'action' => $this->get_button('edit', 'backend/topic/color/edit/' . $row->colorId) . $this->get_button('delete', 'backend/topic/color/delete/' . $row->colorId.'/'.$row->pId)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
}