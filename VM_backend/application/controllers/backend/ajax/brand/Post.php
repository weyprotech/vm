<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Post extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** post ********************/
    public function get_post_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $brandId = $this->input->get('brandId',true);
        $filter = array('like' => array('field' => 'lang.title', 'value' => $search),array('field' => 'post.brandId','value' => $brandId));
        $order = array(array('field' => 'post.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('brand/tb_post_model', 'post');
        $postList = $this->post->get_post_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->post->count_post($filter, $this->langId);
        if ($postList):
            foreach ($postList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                
                    'title' => $row->title,
                    'comments' => '<a class="btn btn-success" href="'.site_url('backend/brand/Post_message/index/'.$row->postId).'"><i class="fa fa-book"></i><span class="hidden-mobile"> Comments</span></button>',
                    'order' => $this->get_order('post', $row->postId, $row->order),
                    'action' => $this->get_button('edit', 'backend/brand/post/edit/' . $row->postId . $query) . $this->get_button('delete', 'backend/brand/post/delete/' . $row->postId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    /**** 貼文圖片 ****/
    public function get_post_img($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $postId = check_input_value($this->input->get('postid',true));

        $filter = array(array('field' => 'post_img.postId', 'value' => $postId));
        $order = array(array('field' => 'post_img.order', 'dir' => 'asc'));

        $this->load->model('brand/tb_post_model', 'post');
        $postList = $this->post->get_post_img_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->post->count_post_img($filter, $this->langId);
        if ($postList):
            foreach ($postList as $row):
                $data[] = array(
                    'preview' => '<div id="preview">' . (!empty($row->postImg) ? '<img src="' . base_url($row->postImg) . '" width="100%">' : '') . '</div>',
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
        $postId = $post['postId'];
        $Id = $post['Id'];
        $youtube = $post['youtube'];
        $this->checkUploadPath('brand/post/'); // 上傳路徑

        // $file = 'assets/uploads/brand/post/'.$postId;        
        // $filePath = '';
        $this->load->model('brand/tb_post_model', 'post_model');

        if($_FILES){
            // if (!is_dir($this->uploadPath .= $file.'/')) mkdir($this->uploadPath, 0777,true);
            foreach ($_FILES as $key => $value) {

                $file = $this->uploadImg($_FILES[0],$postId.'/',510);


                if($Id == 'new'){                    
                    $this->post_model->insert_post_img(array('postImg' => $file['thumbPath'],'postId' => $postId,'youtube' => $youtube));
                }else{
                    $old_file = $this->post_model->get_post_img_by_id($Id);
                    $this->post_model->update_post_img_select($old_file,array('postImg' => $file['thumbPath'],'postId' => $postId,'youtube' => $youtube));
                }      
            }     
        }else{
            $old_file = $this->post_model->get_post_img_by_id($Id);
            $this->post_model->update_post_img_select($old_file,array('postId' => $postId,'youtube' => $youtube));
        }
        echo json_encode(array('status' => true));
        return true;
    }

    public function delete_img(){
        $this->load->model('brand/tb_post_model', 'post_model');

        $Id = $this->input->post('Id',true);
        $old_file = $this->post_model->get_post_img_by_id($Id);
        $this->post_model->delete_post_img($old_file);
        echo json_encode(array('status' => true));
        return true;
    }

    public function upload()
    {
        $postId = $this->input->post('postId', true);
        if ($postId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                $this->checkUploadPath('brand/post/'); // 上傳路徑
                
                $filePath = $this->uploadImg($_FILES['file'], $postId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }

    /***** Message *****/
    public function get_post_message_data($data = array()){
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $postId = $this->input->get('postId',true);
        $filter = array('like' => array('field' => 'lang.title', 'value' => $search),array('field' => 'message.postId','value' => $postId));
        $order = array(array('field' => 'post.order', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        $this->load->model('brand/tb_post_model', 'post');
        $messageList = $this->post->get_post_message_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->post->count_post_message($filter, $this->langId);
        if ($messageList):
            foreach ($messageList as $row):
                $data[] = array(
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                
                    'message' => $row->message,
                    'response' => $row->response,                    
                    'action' => $this->get_button('edit', 'backend/brand/post/edit/' . $row->postId . $query) . $this->get_button('delete', 'backend/brand/post/delete/' . $row->postId . $query).'&nbsp;&nbsp;<a class="btn btn-success" href="'.site_url('backend/brand/post/message/'.$row->postId).'"><i class="fa fa-book"></i><span class="hidden-mobile"> Message</span></button>'
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    /******************** End post ********************/
}