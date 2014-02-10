<?php

if (!defined('WPLESS_VERSION')) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

class WPLESS_Admin
{
    public function __construct(  ) {
        add_action('admin_menu', array($this, 'plugin_menu'));
        add_action('after_setup_theme', array($this, 'init'), 20);
        add_action('acf/save_post', array($this, 'save_post'), 20);
    }

    public function init (  ) {
        // TODO: Make these configurable in the plugin settings page
        define('WPLESS_EDIT_FILE', ASSETS_PATH . '/less/custom.less');
        define('WPLESS_MASTER_FILE', ASSETS_PATH . '/less/lift.less');
        define('WPLESS_TARGET_FILE', ASSETS_PATH . '/css/lift.css');

        $this->register_options_panel();
        $this->register_fields();
    }

    public function plugin_menu(  ) {
        add_options_page(
            'WordPress LESS Editor', 
            'LESS Editor', 
            'manage_options', 
            'wpless_editor', 
            array($this, 'plugin_options')
        );
    }

    public function plugin_options(  ) {
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        echo '<div class="wrap"><p>testing.</p></div>';
    }

    protected function register_options_panel(  ) {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page('Site Colors');
        }
    }

    protected function register_fields(  ) {
        if (function_exists("register_field_group")) {
            register_field_group(array (
                'id' => 'acf_custom-colors',
                'title' => 'Custom Colors',
                'fields' => array (
                    array (
                        'key' => 'wpless_brand-primary',
                        'label' => 'Brand Primary',
                        'name' => 'brand_primary',
                        'type' => 'color_picker',
                        'instructions' => 'This is the main color used for buttons and other highlights.',
                        'default_value' => '#428bca',
                    ),
                    array (
                        'key' => 'wpless_menu-bg-color',
                        'label' => 'Menu Background Color',
                        'name' => 'menu_bg_color',
                        'type' => 'color_picker',
                        'instructions' => 'This is the color behind the nav bar.',
                        'default_value' => '#000000',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'acf-options-site-colors',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'no_box',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ));
        }

    }

    public function save_post( $post_id ) {
        $file = fopen(WPLESS_EDIT_FILE, 'w+');

        foreach ($_POST['fields'] as $field_name => $field_value) {
            if (!empty($field_value)) {
                $varname = str_replace('wpless_', '@', $field_name);
                fwrite($file, $varname . ': ' . $field_value . ';' . PHP_EOL);
            }
        }

        fclose($file);
    }
}
