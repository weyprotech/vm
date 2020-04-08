<?php defined('BASEPATH') OR exit('No direct script access allowed');

$formLang = langText('contact', 'form');
$config = array(
    'contact' => array(
        array('field' => 'contact[name]', 'label' => $formLang['name'], 'rules' => 'trim|required'),
        array('field' => 'contact[phone]', 'label' => $formLang['phone'], 'rules' => 'trim|required'),
        array('field' => 'contact[email]', 'label' => $formLang['email'], 'rules' => 'trim|required|valid_email'),
        array('field' => 'contact[title]', 'label' => $formLang['title'], 'rules' => 'trim|required'),
        array('field' => 'contact[content]', 'label' => $formLang['content'], 'rules' => 'trim|required')
    )
);