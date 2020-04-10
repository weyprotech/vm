<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** member ********************/
    public function get_member_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $this->load->model('tb_member_model', 'member_model');
        $filter['like'] = array('field' => 'lang.name', 'value' => $search);        
        $order = array(array('field' => 'member.create_at', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        
        $memberList = $this->member_model->get_member_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->member_model->count_member($filter, $this->langId);

        if ($memberList):
            foreach ($memberList as $row):
                $data[] = array(                    
                    'preview' => '<div id="preview">' . (!empty($row->memberImg) ? '<img src="' . base_url($row->memberImg) . '">' : '') . '</div>',
                    'email' => $row->email,
                    'first_name' => $row->first_name,
                    'last_name' => $row->last_name,
                    'gender' => $row->gender == 0 ? '男' : '女',
                    'age' => $row->age,
                    'point' => $row->point,
                    'action' => $this->get_button('edit', 'backend/member/edit/' . $row->memberId . $query) . $this->get_button('delete', 'backend/member/delete/' . $row->memberId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    function get_member_order()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('tb_member_model', 'member');

        $minorId = $this->input->get('minorId');
        echo json_encode(array('order' => $this->member->count_member(array(array('field' => 'member.cId', 'value' => $minorId))) + 1));
        return true;
    }
    /******************** End member ********************/
    /******************** member image ******************/
    public function get_member_img($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $memberId = check_input_value($this->input->get('memberId',true));

        $filter = array(array('field' => 'member_img.pId', 'value' => $memberId));
        $order = array(array('field' => 'member_img.order', 'dir' => 'desc'));

        $this->load->model('member/tb_member_model', 'member_model');
        $memberList = $this->member_model->get_member_img_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->member_model->count_member_img($filter, $this->langId);
        if ($memberList):
            foreach ($memberList as $row):
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
        $memberId = $post['memberId'];
        $Id = $post['Id'];
        $youtube = $post['youtube'];
        $file = 'member/member/'.$memberId;        
        $filePath = '';
        $this->load->model('member/tb_member_model', 'member_model');

        if($_FILES){
            if (!is_dir($this->uploadPath .= $file.'/')) mkdir($this->uploadPath, 0777,true);
            $config['upload_path'] = 'assets/uploads/'.$file.'/';
            $small_file = $this->uploadImg($_FILES['small_file'],'/',300);
            $middle_file = $this->uploadImg($_FILES['middle_file'],'/',470);
            $big_file = $this->uploadImg($_FILES['big_file'],'/',600);

            if($Id == 'new'){
                $this->member_model->insert_member_img(array('small_thumbPath' => $small_file['thumbPath'],'small_imagePath' => $small_file['imagePath'],'middle_thumbPath' => $middle_file['thumbPath'],'middle_imagePath' => $middle_file['imagePath'],'big_thumbPath' => $big_file['thumbPath'],'big_imagePath' => $big_file['imagePath'],'pId' => $memberId,'youtube' => $youtube));
            }else{
                $old_file = $this->member_model->get_member_img_by_id($Id);
                $this->member_model->update_member_img($old_file,array('small_thumbPath' => $small_file['thumbPath'],'small_imagePath' => $small_file['imagePath'],'middle_thumbPath' => $middle_file['thumbPath'],'middle_imagePath' => $middle_file['imagePath'],'big_thumbPath' => $big_file['thumbPath'],'big_imagePath' => $big_file['imagePath'],'pId' => $memberId,'youtube' => $youtube));
            }
        }else{
            $old_file = $this->member_model->get_member_img_by_id($Id);
            $this->member_model->update_member_img($old_file,array('pId' => $memberId,'youtube' => $youtube));
        }
        echo json_encode(array('status' => true));
        return true;
    }

    public function upload()
    {
        $memberId = $this->input->post('memberId', true);
        if ($memberId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                $this->uploadPath = 'assets/uploads/member/member/';
                $filePath = $this->uploadImg($_FILES['file'], $memberId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }

    public function delete_img(){
        $this->load->model('member/tb_member_model', 'member_model');

        $Id = $this->input->post('Id',true);
        $old_file = $this->member_model->get_member_img_by_id($Id);
        $this->member_model->delete_member_img($old_file);
        echo json_encode(array('status' => true));
        return true;
    }
    /************** End member img *******************/

    /************** Start member color **********/
    public function get_member_color($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $memberId = check_input_value($this->input->get('memberId',true));

        $filter = array(array('field' => 'member_color.pId', 'value' => $memberId));
        $order = array(array('field' => 'member_color.order', 'dir' => 'asc'));

        $this->load->model('member/tb_member_model', 'member_model');
        $memberList = $this->member_model->get_member_color_select($filter, $order, array('limit' => $limit, 'start' => $start), 3);
        $recordsTotal = $this->member_model->count_member_color($filter, $this->langId);
        if ($memberList):
            foreach ($memberList as $row):
                $data[] = array(  
                    'visible' => '<td><img src="' . show_enable_image($row->is_visible) . '" width="25"></td>',                    
                    'color' => $row->color,
                    'action' => $this->get_button('edit', 'backend/member/color/edit/' . $row->colorId) . $this->get_button('delete', 'backend/member/color/delete/' . $row->colorId.'/'.$row->pId)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
}