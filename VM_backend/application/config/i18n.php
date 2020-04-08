<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * I18n library configuration file
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Lawrence Cheung
 * @version     1.0
 * @link        https://github.com/lawrence0819
 */

//Add file in this array, if you want I18n library auto load them
$config['language']['files'] = array('common');

//If user locale not found, set this value as a default user locale
$config['language']['default_locale'] = 'en';

//Default language folder, if locale folder not found
$config['language']['locale']['default'] = 'en';

$config['language']['locale']['zh-TW'] = 'tw';
$config['language']['locale']['zh-CN'] = 'cn';
$config['language']['locale']['en'] = 'en';
$config['language']['locale']['fr'] = 'fr';
$config['language']['locale']['de'] = 'de';
$config['language']['locale']['es'] = 'es';
$config['language']['locale']['it'] = 'it';

/* End of file i18n.php */
/* Location: ./application/config/i18n.php */