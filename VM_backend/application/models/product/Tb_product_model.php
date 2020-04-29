<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_product_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUploadPath('product/product/'); // 上傳路徑
    }

    /******************** Product Model ********************/
    public function get_product_select($filter = false, $order = false, $limit = false, $langId = false)
    {
        $this->set_product_join($langId);
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('product.is_enable', 1)->get('tb_product as product');
        if ($query->num_rows() > 0):
            return $query->result();
        endif;

        return false;
    }

    public function count_product($filter = false, $langId = false)
    {
        $this->set_product_join($langId);
        $this->set_filter($filter);
        return $this->db->where('product.is_enable', 1)->count_all_results('tb_product as product');
    }

    public function get_product_by_id($productId = false, $langId = false, $boolean = array('enable' => true, 'visible' => true))
    {
        $this->set_product_join($langId);
        $this->set_filter(array(array('field' => 'product.is_enable', 'value' => $boolean['enable']), array('field' => 'product.is_visible', 'value' => $boolean['visible'])));
        $query = $this->db->where('product.productId', $productId)->get('tb_product as product');

        if ($query->num_rows() > 0):
            $product = $query->row();
            if (!$langId):
                $product->langList = $this->get_product_lang_select(array(array('field' => 'pId', 'value' => $product->productId)));
            endif;

            return $product;
        endif;

        return false;
    }

    public function insert_product($post)
    {
        $post['create_at'] = date("Y-m-d H:i:s");
        $insert = $this->check_db_data($post);
        if (isset($_FILES['productImg']) && !$_FILES['productImg']['error']):
            $insert['productImg'] = $this->uploadFile('product', $post['productId'] . '/', 300);
        endif;
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_product_lang($post['productId'], $post['langList']);
        endif;

        $this->db->insert('tb_product', $insert);
        return true;
    }

    public function update_product($product, $post)
    {
        $update = $this->check_db_data($post);

        if (isset($_FILES['productImg']) && !$_FILES['productImg']['error']):
            $update['productImg'] = $this->uploadFile('product', $product->productId . '/', 300);
            @unlink($product->productImg);
        endif;

        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_product_lang($product->productId, $post['langList']);
        endif;

        $this->db->update('tb_product', $update, array('productId' => $product->productId));
        return true;
    }

    public function delete_product($product)
    {
        $this->update_product($product, array('is_enable' => 0));
        return $this->reorder_product($product->cId);
    }

    /*************** 重新排序 ***************/
    private function reorder_product($cId)
    {
        $result = $this->get_product_select(array(array('field' => 'product.cId', 'value' => $cId)), array(array('field' => 'product.order', 'dir' => 'asc')));
        if ($result):
            foreach ($result as $i => $row):
                $order[] = $this->check_db_data(array('productId' => $row->productId, 'order' => $i + 1));
            endforeach;

            return $this->db->update_batch('tb_product', $order, 'productId');
        endif;

        return true;
    }

    /*************** Product Lang Model ***************/
    private function get_product_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_product_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_product_lang($productId, $update)
    {
        $this->db->where('pId', $productId)->update_batch('tb_product_lang', $update, 'langId');

        $langList = $this->get_product_lang_select(array(array('field' => 'pId', 'value' => $productId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_product_lang', $insert);
        endif;

        return true;
    }
    /*************** End Product Lang Model ***************/    
    /*************** start Product img Model ********/
    public function get_product_img_select($filter = false,$order = false,$limit = false){
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->get('tb_product_image as product_img');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function get_product_img_by_id($id){
        $query = $this->db->where('imageId',$id)->get('tb_product_image as product_img');
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function count_product_img($filter = false){
        $this->set_filter($filter);
        $count = $this->db->count_all_results('tb_product_image as product_img');
        return $count;
    }

    public function insert_product_img($post){
        $insert = $post;
        $insert['order'] = $this->count_product_img() + 1;

        $this->db->insert('tb_product_image',$insert);

        return $this->db->insert_id();
    }

    public function update_product_img($img,$post){
        $update = $post;
        $this->db->update('tb_product_image',$update,array('imageId' => $img->imageId));
        return true;
    }

    public function delete_product_img($img){
        //刪除圖檔
        if(file_exists($this->uploadPath .$img->small_imagePath)){
            @chmod($this->uploadPath .$img->small_imagePath, 0777);
            @unlink($this->uploadPath .$img->small_imagePath);
        }
        if(file_exists($this->uploadPath .$img->small_thumbPath)){
            @chmod($this->uploadPath .$img->small_thumbPath, 0777);
            @unlink($this->uploadPath .$img->small_thumbPath);
        }
        if(file_exists($this->uploadPath .$img->middle_imagePath)){
            @chmod($this->uploadPath .$img->middle_imagePath, 0777);
            @unlink($this->uploadPath .$img->middle_imagePath);
        }
        if(file_exists($this->uploadPath .$img->middle_thumbPath)){
            @chmod($this->uploadPath .$img->middle_thumbPath, 0777);
            @unlink($this->uploadPath .$img->middle_thumbPath);
        }
        if(file_exists($this->uploadPath .$img->big_imagePath)){
            @chmod($this->uploadPath .$img->big_imagePath, 0777);
            @unlink($this->uploadPath .$img->big_imagePath);
        }
        if(file_exists($this->uploadPath .$img->big_thumbPath)){
            @chmod($this->uploadPath .$img->big_thumbPath, 0777);
            @unlink($this->uploadPath .$img->big_thumbPath);
        }

        $this->db->delete('tb_product_image',array('imageId' => $img->imageId));

        return true;
    }
    /******************** End Product img Model ****************/
    /******************** Start Product size Mpdel *************/
    public function get_product_size_select($filter = false,$order = false,$limit = false){
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->get('tb_product_size as product_size');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function get_product_size_by_id($id){
        $query = $this->db->where('Id',$id)->get('tb_product_size as product_size');
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function count_product_size($filter = false){
        $this->set_filter($filter);
        $count = $this->db->count_all_results('tb_product_size as product_size');
        return $count;
    }

    public function insert_product_size($post,$pId){
        $insert = array();
        foreach($post as $postKey => $postValue){
            $insert['size'] = $postValue;
            $insert['pId'] = $pId;
            $this->db->insert('tb_product_size',$insert);
        }
    }

    public function update_product_size($size,$post,$productId){
        foreach($size as $sizeKey => $sizeValue){
            if(!$key = array_search($sizeValue->size,$post)){
                $this->db->delete('tb_product_size',array('Id' => $sizeValue->Id));
            }else{
                unset($post[$key]);
            }            
        }
        if(!empty($post)){
            foreach($post as $postKey => $postValue){
                $insert['size'] = $postValue;
                $insert['pId'] = $productId;
                $this->db->insert('tb_product_size',$insert);
            }
        }       
        return true;
    }

    public function delete_product_size($size){
        $this->db->delete('tb_product_size',array('Id' => $size->Id));

        return true;
    }


    /******************** End Product Size Model ***************/
    /******************** Start Product Color Model ************/
    public function get_product_color_select($filter = false,$order = false,$limit = false,$langId){
        $this->set_product_color_join($langId);
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->where('is_enable',1)->get('tb_product_color as product_color');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function get_product_color_by_id($id,$langId){
        $this->set_product_color_join($langId);
        $query = $this->db->where('colorId',$id)->get('tb_product_color as product_color');
        if ($query->num_rows() > 0):
            $color = $query->row();
            if (!$langId):
                $color->langList = $this->get_product_color_lang_select(array(array('field' => 'cId', 'value' => $color->colorId)));
            endif;

            return $color;
        endif;
        return false;
    }

    public function count_product_color($filter = false){
        $this->set_filter($filter);
        $count = $this->db->where('is_enable',1)->count_all_results('tb_product_color as product_color');
        return $count;
    }

    public function insert_product_color($post){
        $post['is_enable'] = 1;
        $insert = $this->check_db_data($post);
        $this->db->insert('tb_product_color',$insert);
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_product_color_lang($post['colorId'], $post['langList']);
        endif;
        return true;
    }

    public function update_product_color($color,$post){
        $update = $this->check_db_data($post);
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_product_color_lang($color->colorId, $post['langList']);
        endif;
        $this->db->update('tb_product_color',$update,array('colorId' => $color->colorId));
        return true;
    }

    public function delete_product_color($color){
        $this->update_product_color($color, array('is_enable' => 0));
        return true;
    }

    /*************** Product color Lang Model ***************/
    private function get_product_color_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_product_color_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_product_color_lang($colorId, $update)
    {
        $this->db->where('cId', $colorId)->update_batch('tb_product_color_lang', $update, 'langId');

        $langList = $this->get_product_color_lang_select(array(array('field' => 'cId', 'value' => $colorId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_product_color_lang', $insert);
        endif;

        return true;
    }    
    /******************** End Product Color Model **************/
    /******************** Start Product manufacture Model ************/
    public function get_product_manufacture_select($filter = false,$order = false,$limit = false,$langId = false){
        $this->set_product_manufacture_join($langId);
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->get('tb_product_manufacture as product_manufacture');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function get_product_manufacture_by_id($id,$langId = false){
        $this->set_product_manufacture_join($langId);
        $query = $this->db->where('Id',$id)->get('tb_product_manufacture as product_manufacture');
        if ($query->num_rows() > 0):
            $manufacture = $query->row();
            if (!$langId):
                $manufacture->langList = $this->get_product_manufacture_lang_select(array(array('field' => 'mId', 'value' => $manufacture->Id)));
            endif;

            return $manufacture;
        endif;
        return false;
    }

    public function get_product_manufacture_by_pid($pid,$langId = false){
        $this->set_product_manufacture_join($langId);
        $query = $this->db->where('pId',$pid)->get('tb_product_manufacture as product_manufacture');
        if ($query->num_rows() > 0):
            $manufacture = $query->row();
            if (!$langId):
                $manufacture->langList = $this->get_product_manufacture_lang_select(array(array('field' => 'mId', 'value' => $manufacture->Id)));
            endif;

            return $manufacture;
        endif;
        return false;
    }

    public function insert_product_manufacture($pId){
        $post['pId'] = $pId;
        $post['uuid'] = uniqid();
        $insert = $this->check_db_data($post);
        $this->db->insert('tb_product_manufacture',$insert);        
        return $this->db->insert_id();
    }

    public function update_product_manufacture($manufacture,$post){
        $update = $this->check_db_data($post);
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_product_manufacture_lang($manufacture->Id, $post['langList']);
        endif;

        if (isset($_FILES['firstbannerImg']) && !$_FILES['firstbannerImg']['error']):
            $update['firstbannerImg'] = $this->uploadFile('firstbanner', $manufacture->Id . '/', 1920);
        endif;

        if (isset($_FILES['iconImg']) && !$_FILES['iconImg']['error']):
            $update['iconImg'] = $this->uploadFile('icon', $manufacture->Id . '/', 100);
        endif;

        if (isset($_FILES['content1Img']) && !$_FILES['content1Img']['error']):
            $update['content1Img'] = $this->uploadFile('content1', $manufacture->Id . '/', 380);
        endif;

        if (isset($_FILES['content2Img']) && !$_FILES['content2Img']['error']):
            $update['content2Img'] = $this->uploadFile('content2', $manufacture->Id . '/', 380);
        endif;

        if (isset($_FILES['secondbannerImg']) && !$_FILES['secondbannerImg']['error']):
            $update['secondbannerImg'] = $this->uploadFile('secondbanner', $manufacture->Id . '/', 1920);
        endif;

        if (isset($_FILES['popup1Img']) && !$_FILES['popup1Img']['error']):
            $update['popup1Img'] = $this->uploadFile('popup1', $manufacture->Id . '/', 936);
        endif;

        if (isset($_FILES['popup2Img']) && !$_FILES['popup2Img']['error']):
            $update['popup2Img'] = $this->uploadFile('popup2', $manufacture->Id . '/', 936);
        endif;

        if (isset($_FILES['popup3Img']) && !$_FILES['popup3Img']['error']):
            $update['popup3Img'] = $this->uploadFile('popup3', $manufacture->Id . '/', 936);
        endif;
        $this->db->update('tb_product_manufacture',$update,array('Id' => $manufacture->Id));
        return true;
    }


    /*************** Product manufacture Lang Model ***************/
    private function get_product_manufacture_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_product_manufacture_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_product_manufacture_lang($mId, $update)
    {
        $this->db->where('mId', $mId)->update_batch('tb_product_manufacture_lang', $update, 'langId');

        $langList = $this->get_product_manufacture_lang_select(array(array('field' => 'mId', 'value' => $mId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_product_manufacture_lang', $insert);
        endif;

        return true;
    }    
    /******************** End Product manufacture Lang Model **************/

    /******************** Start Product fabric Model ************/
    public function get_product_fabric_select($filter = false,$order = false,$limit = false,$langId = false){
        $this->set_product_fabric_join($langId);
        $this->set_filter($filter);
        $this->set_order($order);
        $this->set_limit($limit);
        $query = $this->db->get('tb_product_fabric as product_fabric');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function get_product_fabric_by_id($id,$langId = false){
        $this->set_product_fabric_join($langId);
        $query = $this->db->where('Id',$id)->get('tb_product_fabric as product_fabric');
        if ($query->num_rows() > 0):
            $fabric = $query->row();
            if (!$langId):
                $fabric->langList = $this->get_product_fabric_lang_select(array(array('field' => 'fId', 'value' => $fabric->Id)));
            endif;

            return $fabric;
        endif;
        return false;
    }

    public function get_product_fabric_by_pid($pid,$langId = false){
        $this->set_product_fabric_join($langId);
        $query = $this->db->where('pId',$pid)->get('tb_product_fabric as product_fabric');
        if ($query->num_rows() > 0):
            $fabric = $query->row();
            if (!$langId):
                $fabric->langList = $this->get_product_fabric_lang_select(array(array('field' => 'fId', 'value' => $fabric->Id)));
            endif;

            return $fabric;
        endif;
        return false;
    }

    public function insert_product_fabric($pId){
        $post['pId'] = $pId;
        $post['uuid'] = uniqid();
        $insert = $this->check_db_data($post);
        $this->db->insert('tb_product_fabric',$insert);        
        return $this->db->insert_id();
    }

    public function update_product_fabric($fabric,$post){
        $update = $this->check_db_data($post);
        if (isset($post['langList'])):
            foreach ($post['langList'] as $i => $lrow):
                $post['langList'][$i] = $this->check_db_data($lrow);
            endforeach;

            $this->update_product_fabric_lang($fabric->Id, $post['langList']);
        endif;

        if (isset($_FILES['firstbannerImg']) && !$_FILES['firstbannerImg']['error']):
            $update['firstbannerImg'] = $this->uploadFile('firstbanner', $fabric->Id . '/', 1920);
        endif;

        if (isset($_FILES['iconImg']) && !$_FILES['iconImg']['error']):
            $update['iconImg'] = $this->uploadFile('icon', $fabric->Id . '/', 100);
        endif;

        if (isset($_FILES['content1Img']) && !$_FILES['content1Img']['error']):
            $update['content1Img'] = $this->uploadFile('content1', $fabric->Id . '/', 380);
        endif;

        if (isset($_FILES['content2Img']) && !$_FILES['content2Img']['error']):
            $update['content2Img'] = $this->uploadFile('content2', $fabric->Id . '/', 380);
        endif;

        if (isset($_FILES['secondbannerImg']) && !$_FILES['secondbannerImg']['error']):
            $update['secondbannerImg'] = $this->uploadFile('secondbanner', $fabric->Id . '/', 1920);
        endif;

        if (isset($_FILES['popup1Img']) && !$_FILES['popup1Img']['error']):
            $update['popup1Img'] = $this->uploadFile('popup1', $fabric->Id . '/', 936);
        endif;

        if (isset($_FILES['popup2Img']) && !$_FILES['popup2Img']['error']):
            $update['popup2Img'] = $this->uploadFile('popup2', $fabric->Id . '/', 936);
        endif;

        if (isset($_FILES['popup3Img']) && !$_FILES['popup3Img']['error']):
            $update['popup3Img'] = $this->uploadFile('popup3', $fabric->Id . '/', 936);
        endif;
        $this->db->update('tb_product_fabric',$update,array('Id' => $fabric->Id));
        return true;
    }


    /*************** Product fabric Lang Model ***************/
    private function get_product_fabric_lang_select($filter = false)
    {
        $langList = array();
        $this->set_filter($filter);
        $query = $this->db->get('tb_product_fabric_lang');
        if ($query->num_rows() > 0):
            foreach ($query->result() as $lrow):
                $langList[$lrow->langId] = $lrow;
            endforeach;
        endif;

        return $langList;
    }

    private function update_product_fabric_lang($fId, $update)
    {
        $this->db->where('fId', $fId)->update_batch('tb_product_fabric_lang', $update, 'langId');

        $langList = $this->get_product_fabric_lang_select(array(array('field' => 'fId', 'value' => $fId)));
        $insert = array_diff_key($update, $langList);
        if (!empty($insert)):
            foreach ($insert as $i => $lrow):
                $insert[$i] = array_merge($lrow, array('create_at' => date("Y-m-d H:i:s")));
            endforeach;

            return $this->db->insert_batch('tb_product_fabric_lang', $insert);
        endif;

        return true;
    }    
    /******************** End Product fabric Lang Model **************/

    /******* 取得所有SIZE ********/
    public function get_size_chart(){
        $query = $this->db->get('tb_size_chart');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }
    /******************** End Product Model ********************/
    /******************** Private Function ********************/
    /*************** 處理資料 ***************/
    private function check_db_data($post)
    {
        $data = array('uuid' => uniqid(), 'update_at' => date("Y-m-d H:i:s"));

        foreach ($post as $field => $value):
            if (!in_array($field, array('mainId', 'imageOrder', 'langList', 'uuid','size','image_list_length'))):
                switch ($field):
                    case 'minorId':
                        $data['cId'] = check_input_value($value, true);
                        break;

                    case 'detail':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;

                    case 'description':
                        $data[$field] = check_input_value(html_entity_decode($value));
                        break;
                    
                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'productId', 'cId', 'pId', /* Product Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }

    private function set_product_join($langId)
    {
        $this->db->select('product.*, minor.prevId as mainId, product.cId as minorId');
        $this->db->join('tb_product_category as minor', 'minor.categoryId = product.cId', 'left');
        $this->db->join('tb_product_category as main', 'main.categoryId = minor.prevId', 'left');
        $this->db->join('tb_product_category as base','base.categoryId = main.prevId','left');
        $this->db->join('tb_brand as brand','brand.brandId = product.brandId','left');
        if ($langId):
            $this->db->select('lang.*, main_lang.name as mainName, minor_lang.name as minorName,base_lang.name as baseName,brand_lang.name as brandName');
            $this->db->join('tb_product_lang as lang', 'lang.pId = product.productId AND lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as main_lang', 'main_lang.cId = minor.prevId AND main_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as minor_lang', 'minor_lang.cId = product.cId AND minor_lang.langId = ' . $langId, 'left');
            $this->db->join('tb_product_category_lang as base_lang','base_lang.cId = base.categoryId AND base_lang.langId = '.$langId,'left');
            $this->db->join('tb_brand_lang as brand_lang','brand.brandId = brand_lang.brandId AND brand_lang.langId = '.$langId,'left');
        endif;

        return true;
    }

    private function set_product_color_join($langId){
        $this->db->select('product_color.*');
        if($langId):
            $this->db->select('color_lang.color');
            $this->db->join('tb_product_color_lang as color_lang','color_lang.cId = product_color.colorId AND color_lang.langId = '.$langId,'left');
        endif;
    }

    private function set_product_manufacture_join($langId){
        $this->db->select('product_manufacture.*');
        if($langId):
            $this->db->select('product_manufacture_lang.location,product_manufacture_lang.title1,product_manufacture_lang.content1,product_manufacture_lang.title2,product_manufacture_lang.content2,product_manufacture_lang.title3,product_manufacture_lang.content3');
            $this->db->join('tb_product_manufacture_lang as product_manufacture_lang','product_manufacture_lang.mId = product_manufacture.Id AND product_manufacture_lang.langId = '.$langId,'left');
        endif;
    }

    private function set_product_fabric_join($langId){
        $this->db->select('product_fabric.*');
        if($langId):
            $this->db->select('product_fabric_lang.location,product_fabric_lang.title1,product_fabric_lang.content1,product_fabric_lang.title2,product_fabric_lang.content2,product_fabric_lang.title3,product_fabric_lang.content3');
            $this->db->join('tb_product_fabric_lang as product_fabric_lang','product_fabric_lang.mId = product_manufacture.Id AND product_fabric_lang.langId = '.$langId,'left');
        endif;
    }
    /******************** End Private Function ********************/
}