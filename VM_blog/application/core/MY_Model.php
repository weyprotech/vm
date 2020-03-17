<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected $model;
    protected $uploadPath = 'assets/uploads/';

    public function __construct()
    {
        parent::__construct();
    }

    /******************** Select Function ********************/
    protected function set_filter($filter)
    {
        if ($filter && $filter = $this->_check_filter_value($filter)) {
            $this->db->group_start();
            foreach ($filter as $type => $row) {
                switch ($type) {
                    case ($type == 'whereIn'):
                        $this->db->where_in($row['field'], $row['value']);
                        break;
                    case ($type == 'orWhere'):
                        $this->db->or_where($row['field'], $row['value']);
                        break;
                    case ($type == 'like'):
                        $this->db->like($row['field'], $row['value']);
                        break;
                    case ($type == 'orLike'):
                        $this->db->or_like($row['field'], $row['value']);
                        break;
                    case ($type == 'having'):
                        $this->db->having($row['field'], $row['value']);
                        break;
                    case ($type == 'other'):
                        $this->db->where($row['value']);
                        break;
                    case ($type == 'group'):
                        $this->set_filter($row['value']);
                        break;
                    default:
                        $this->db->where($row['field'], $row['value']);
                }
            }
            $this->db->group_end();
        }
    }

    private function _check_filter_value($filter)
    {
        return array_filter($filter, function ($row) {
            return isset($row['value']) && (!empty($row['value']) || is_numeric($row['value']));
        });
    }

    protected function set_order($order)
    {
        if ($order) {
            foreach ($order as $row) {
                $this->db->order_by($row['field'], $row['dir']);
            }
        }
    }

    protected function set_limit($limit)
    {
        if ($limit) {
            $this->db->limit($limit['limit'], $limit['start']);
        }
    }
    /******************** End Select Function ********************/

    /******************** Upload Function ********************/
    protected function uploadFile($name, $dir = '', $width = false)
    {
        $this->checkUploadPath($dir, true, false);

        $filePath = null;
        $config['upload_path'] = $this->uploadPath . $dir;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
        $this->load->library('upload', $config);

        /*************** Upload Image ***************/
        if (isset($_FILES[$name . 'Img']) && $this->upload->do_upload($name . 'Img')) {
            $uploadData = $this->upload->data();
            $filePath = $config['upload_path'] . uniqid($name) . $uploadData['file_ext'];

            if (is_numeric($width)) {
                $temp = getimagesize($uploadData['full_path']);
                $thumbWidth = $temp[0] > $width ? $width : $temp[0];
                $thumbHeight = $temp[0] > $width ? ($width / $temp[0]) * $temp[1] : $temp[1];
                $thumbPath = $filePath;

                if ($temp[0] > $width) {
                    if (in_array($uploadData['file_ext'], array('.png', '.gif'))) {
                        image_resize_transparent($uploadData['full_path'], $thumbPath, $thumbWidth, $thumbHeight);
                    } else {
                        $this->load->library("image_moo");
                        $this->image_moo->load($uploadData['full_path'])->resize($thumbWidth, $thumbHeight)->save($thumbPath);
                    }

                    @unlink($uploadData['full_path']);
                    return $thumbPath;
                };
            }
            @rename($uploadData['full_path'], $filePath);

            /*************** Upload File ***************/
        } elseif (isset($_FILES[$name . 'File']) && $this->upload->do_upload($name . 'File')) {
            $uploadData = $this->upload->data();
            $filePath = $config['upload_path'] . uniqid($name) . $uploadData['file_ext'];
            @rename($uploadData['full_path'], $filePath);
        } else {
            js_warn($this->upload->display_errors('', ''));
        }

        return $filePath;
    }

    protected function checkUploadPath($path, $is_create = true, $is_set = true)
    {
        $is_dir = is_dir($this->uploadPath . $path);

        if ($is_create && !$is_dir) {
            mkdir($this->uploadPath . $path, 0777);

            return $this->checkUploadPath($path, false, $is_set);
        }

        if ($is_set) {
            $this->uploadPath .= $path;

            return $this->checkUploadPath('', false, false);
        }

        return $is_dir;
    }
    /******************** End Upload Function ********************/

    /******************** Log Function ********************/
    protected function insert($table, $data)
    {
        $this->create_log("在 " . $table . " 新增資料");
        return $this->db->insert($table, $data);
    }

    protected function update($table, $data, $where)
    {
        $this->create_log("在 " . $table . " 更新 " . key($where) . " 為 " . current($where) . " 的資料");
        return $this->db->update($table, $data, $where);
    }

    protected function delete($table, $data, $where)
    {
        $this->create_log("在 " . $table . " 刪除 " . key($where) . " 為 " . current($where) . " 的資料");
        return $this->db->update($table, $data, $where);
    }

    private function create_log($log = "")
    {
        $data = array(
            'model' => $this->model,
            'log' => $log,
            'create_by' => $this->session->userdata('adminName') . "【" . $this->session->userdata('adminId') . "】"
        );

        $this->db->insert('tb_website_log', $data);
        return $this->db->insert_id();
    }
    /******************** End Log Function ********************/
}