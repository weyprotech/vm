<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_menu_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function menu_get()
    {
        $query = $this->db->order_by("order asc, prevId asc")->get('tb_menu');

        if ($query->num_rows() > 0) return $query->result();
        return false;
    }
}