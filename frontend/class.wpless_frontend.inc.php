<?php

if (!defined('WPLESS_VERSION')) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

class WPLESS_FrontEnd
{
    public function __construct(  ) {
        add_action('after_setup_theme', array($this, 'init'));
    }

    public function init (  ) {
        // TODO: Make these configurable in the plugin settings page
        define('WPLESS_EDIT_FILE', ASSETS_PATH . '/less/custom.less');
        define('WPLESS_MASTER_FILE', ASSETS_PATH . '/less/lift.less');
        define('WPLESS_TARGET_FILE', ASSETS_PATH . '/css/lift.css');

        require_once WPLESS_PATH . '/vendor/leafo/lessphp/lessc.inc.php';

        try {
            $less = new lessc;

            $last_updated = filemtime(WPLESS_EDIT_FILE);
            $last_compiled = filemtime(WPLESS_TARGET_FILE);

            if ($last_updated>$last_compiled) {
                $less->compileFile(WPLESS_MASTER_FILE, WPLESS_TARGET_FILE);
            }
        } catch (exception $e) {
            wp_die(print_r($e, TRUE));
        }
    }
}
