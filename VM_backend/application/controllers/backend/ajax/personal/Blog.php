<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!designer_logged_in()):
            redirect("admin");
        endif;
    }

    public function upload()
    {
        $designerId = $this->input->post('designerId', true);
        if ($designerId && isset($_FILES['file'])):
            if (!$_FILES['file']['error']):
                $config['upload_path'] = 'assets/uploads/designer/blog/';
                $filePath = $this->uploadImg($_FILES['file'], $designerId . '/');
                echo base_url($filePath['imagePath']);
            else:
                echo 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            endif;
        endif;

        return true;
    }
    /******************** End post ********************/
}