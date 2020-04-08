<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/* 
| ------------------------------------------------------------------- 
| EMAIL CONFING 
| ------------------------------------------------------------------- 
| Configuration of outgoing mail server. 
| */

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = '587';
$config['smtp_user'] = 'azure_9131e480018e796d9d0b46988542082b@azure.com';
$config['smtp_pass'] = 'test#12ab';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";

/* End of file email.php */
/* Location: ./system/application/config/email.php */ 