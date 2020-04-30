<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * I18n class
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Lawrence Cheung
 * @version     1.0
 * @link        https://github.com/lawrence0819
 */
class I18n
{

    protected $CI;
    protected $auto = TRUE;
    protected $loaded = FALSE;
    protected $locale;

    /**
     * Constructor - get CI instance
     *
     */
    public function __construct()
    {
        $this->CI = get_instance();
    }

    /**
     * Auto load language for CI HOOK
     *
     * @access  public
     * @return  void
     */
    public function auto_load_language()
    {
        if ($this->auto) {
            $this->load_language();
        }
    }

    /**
     * Manual load language file
     *
     * @access  public
     * @return  void
     */
    public function load_language($cookie_key = 'locale')
    {
        $lang = $this->get_current_locale($cookie_key);
        $language = $this->get_language_config();

        if (!$this->loaded) {
            $files = $language['files'];
            $locale = $language['locale'];

            if (array_key_exists($lang, $locale)) {
                $folder = $locale[$lang];
            } else {
                $shortLang = substr($lang, 0, 2);
                if (array_key_exists($shortLang, $locale)) {
                    $folder = $locale[$shortLang];
                } else {
                    $folder = $locale['default'];
                }
            }

            foreach ($files as $file) {
                $this->CI->lang->load($file, $folder);
            }

            $this->loaded = TRUE;
        }
    }

    /**
     * Prevent CI Hook to auto load language file
     *
     * @access  public
     * @return  void
     */
    public function prevent_auto()
    {
        $this->auto = FALSE;
    }

    /**
     * Set current user locale and save locale to cookies
     *
     * @access  public
     * @Param   string      the locale string: en-US, en-UK, zh-TW, zh-CN
     * @Param   integer     the cookies value expire time, default is 30 day
     * @Param   string      cookies key
     * @return  void
     */
    public function set_current_locale($locale, $expire = 60, $cookie_key = 'locale')
    {
        $this->CI->session->set_tempdata($cookie_key, $locale, $expire);
        $this->locale = $locale;
    }

    /**
     * Get current user locale
     *
     * @access  public
     * @Param   string      cookies key, if you changed the key at set_current_locale, please assign it
     * @return  string
     */
    public function get_current_locale($cookie_key = 'locale')
    {
        if (!$this->locale) {
            $language = $this->get_language_config();
            $locale = $language['locale'];

            if (isset($_SESSION[$cookie_key])) {
                $lang = 'en';
                // $lang = $this->CI->session->tempdata($cookie_key);
            } else {
                if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
                    $lang = !isset($locale[$lang]) ? $locale['default'] : $lang;
                } else {
                    $lang = $locale['default'];
                }
            }

            $this->locale = $lang;
        }
        return $this->locale;
    }

    /**
     * Get configuration values
     *
     * @access  default
     * @return  array
     */
    function get_language_config()
    {
        $this->CI->config->load('i18n');
        return $this->CI->config->item('language');
    }

}

/* End of file I18n.php */
/* Location: ./application/libraries/I18N.php */