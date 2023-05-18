<?php

class shtcLoadTheme
{
    private static $_instance = null;

    public function __construct()
    {
        $files = glob(SH_THEME_INC . 'woocommerce/*.php');
        foreach ($files as $file){
            require_once $file;
        }

        add_action('wp_enqueue_scripts' , [$this ,'enequeueTheme']);

    }

    public static function instance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function enequeueTheme()
    {
        wp_enqueue_style('sh-main-style', SH_THEME_URL .'style.css' , [], '1.0.0');
    }
}

shtcLoadTheme::instance();
