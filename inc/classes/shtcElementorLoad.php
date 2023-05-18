<?php
if (!defined('SH_THEME_DIR')) {
    exit('No direct script access allowed');
}

class shtcElementorLoad
{
    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.7.0';
    const MINIMUM_PHP_VERSION = '7.3';
    private static $_instance = null;

    public static function instance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        //ایا همه نیازمندیها لود شده اند
        if ($this->is_compatible()) {
            add_action('wp_enqueue_scripts', [$this, 'enqueue_widget']);
            add_action('elementor/init', [$this, 'init']);
        }
    }

    public function enqueue_widget()
    {
        $widgets_folders = glob(SH_THEME_INC . 'ele/widgets/*');

        foreach ($widgets_folders as $folder) {
            $styles = glob($folder . '/*.css');
            $scripts = glob($folder . '/*.js');

            if (! empty($styles)){
                foreach ($styles as $style) {

                    //change path to url
                    $url = SH_THEME_URL . 'inc/ele/widgets/'. basename($folder) . '/' . basename($style);
    
                    $handle = 'sh-widget-' . sh_get_name_by_path($style) . '-css';
                    wp_register_style($handle, $url , [], '1.0.0');
                }
            }

            if (! empty($scripts)){
                foreach ($scripts as $script) {

                    //change path to url
                    $url = SH_THEME_URL . 'inc/ele/widgets/'. basename($folder) . '/' . basename($script);
    
                    $handle = 'sh-widget-' . sh_get_name_by_path($script) . '-js';
                    wp_register_script($handle, $url , ['jquery'], '1.0.0' , true);
                }
            }
        }
    }

    /**
     * Compatibility Checks
     *
     * Checks whether the site meets the addon requirement.
     *
     * @since 1.0.0
     * @access public
     */
    public function is_compatible()
    {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice']);
            return false;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice']);
            return false;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice']);
            return false;
        }

        return true;
    }


    public function admin_notice()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-addon'),
            '<strong>' . esc_html__('Elementor Test Addon', 'elementor-test-addon') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-test-addon') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /*
	 * Fired by `elementor/init` action hook.
	 */
    public function init()
    {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/controls/register', [$this, 'register_controls']);
        add_action('elementor/elements/categories_registered', [$this, 'categories_registere']);
    }

    public function categories_registere($elements_manager)
    {
        $elements_manager->add_category(
            'sh_category',
            [
                'title' => esc_html__('shopi theme widget', 'sh_textdomain'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    public function register_widgets($widgets_manager)
    {
        $widgets_folders = glob(SH_THEME_INC . 'ele/widgets/*');

        foreach ($widgets_folders as $folder) {
            $widgets = glob($folder . '/shtc*.php');
            foreach ($widgets as $widget) {

                require_once($widget);

                $class = sh_get_name_by_path($widget);
                $widgets_manager->register(new $class);
            }
        }
    }

    public function register_controls($controls_manager)
    {
        $controls = glob(SH_THEME_INC . 'ele/controls/shtc*.php');

        foreach ($controls as $control) {
            require_once($control);

            $class = sh_get_name_by_path($control);
            $controls_manager->register(new $class);
        }
    }
}

if (sh_is_elementor_installed()) {
    shtcElementorLoad::instance();
    include_once SH_THEME_INC . 'ele/elementor.php';
}
