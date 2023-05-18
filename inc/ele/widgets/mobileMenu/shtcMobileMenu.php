<?php
if (!defined('ABSPATH')) {
    exit; // Direct access not allowed.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;

class shtcMobileMenu extends Widget_Base
{
    public $name = 'mobileMenu';

    public function get_name()
    {
        return $this->name;
    }

    public function get_title()
    {
        return esc_html__('mobile menu', 'sh_textdomain');
    }

    public function get_icon()
    {
        return 'eicon-menu-bar';
    }

    public function get_script_depends()
    {
        $handle = 'sh-widget-' . $this->name . '-js';
        return [$handle];
    }

    public function get_style_depends()
    {
        $handle = 'sh-widget-' . $this->name . '-css';
        return [$handle];
    }

    public function get_categories()
    {
        return ['sh_category'];
    }

    protected function _register_controls()
    {
        // Content tab.
        $this->start_controls_section(
            'select',
            [
                'label' => esc_html__('select a menu', 'sh_textdomain'),
            ]
        );

        //get all menus
        $menus = get_terms('nav_menu');
        $menus = array_combine(wp_list_pluck($menus, 'term_id'), wp_list_pluck($menus, 'name'));

        $this->add_control(
            'menu-select',
            array(
                'description' => esc_html__('for use this widget create icon ans set id "mobileMenuOpen"', 'sh_textdomain'),
                'label'   => esc_html__('select a menus', 'sh_textdomain'),
                'type'    => Controls_Manager::SELECT,
                'default' => 0,
                'options' => $menus
            )
        );

        $this->add_control(
            'opening',
            array(
                'label'   => esc_html__('opening from', 'sh_textdomain'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => ['left' => 'left', 'right' => 'right']
            )
        );

        $this->end_controls_section();

        //MENU STYLE
        $this->start_controls_section(
            'menu-style',
            [
                'label' => esc_html__('menu Layout', 'sh_textdomain'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => esc_html__('menu background color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f00',
                'selectors' => [
                    '{{WRAPPER}} .mobileMenu ul , {{WRAPPER}} .mobileMenu'  => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'menu-text_color',
            [
                'label' => esc_html__('text color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'default' => 'black',
                'selectors' => array(
                    '{{WRAPPER}} .mobileMenu i, {{WRAPPER}} .mobileMenu a'  => 'color: {{VALUE}}',
                ),
            ]
        );

        $this->add_control('divider', array('type' => Controls_Manager::DIVIDER));

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'menu-border',
                'selector' => '{{WRAPPER}} .mobileMenu',
            ]
        );

        $this->end_controls_section();

        //list style
        $this->start_controls_section(
            'list_style',
            [
                'label' => esc_html__('list Layout', 'sh_textdomain'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'li-padding',
            [
                'label' => esc_html_x('list padding', 'textdomain'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => array('value' => ''),
                'selectors' => array(
                    '{{WRAPPER}} .mobileMenu li'  => 'padding:{{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'li-border',
                'selector' => '{{WRAPPER}} .mobileMenu li',
            ]
        );


        $this->end_controls_section();
    }

    protected function render()
    {
        sh_mobileMenuRender($this->get_settings_for_display());
    }
}
include_once(SH_THEME_INC . 'ele/widgets/mobileMenu/mobileMenu.php');