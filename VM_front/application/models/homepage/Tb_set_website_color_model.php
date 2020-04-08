<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_set_website_color_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();        
    }

    /******************** sale Model ********************/
    /******************** start set website color **************/
    public function get_set_website_color(){
        $query = $this->db->where('website_color.Id',1)->get('tb_set_website_color as website_color');
        if($query->num_rows() > 0){
            return $query->row();            
        }
        return false;
    }

    public function update_set_website_color($post){
        $update = $this->check_db_data($post);
        $this->db->update('tb_set_website_color',$update,array('Id' => 1));
        return true;
    }
    /********************* end set website color ****************/
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

                    default:
                        $int_array = array(
                            'is_enable', 'is_visible', 'langId', 'order', /* Common Field */
                            'saleId', 'cId', 'pId', /* sale Field */
                            'imageId', 'prevId'
                        );
                        $data[$field] = check_input_value($value, in_array($field, $int_array));
                endswitch;
            endif;
        endforeach;

        return $data;
    }
    /******************** 處理資料 ********************/
}