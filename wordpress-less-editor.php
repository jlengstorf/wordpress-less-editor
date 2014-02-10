<?php
/*
Plugin Name: WordPress LESS Editor
Version: 0.0.1b
Plugin URI: https://github.com/jlengstorf/wordpress-less-editor
Description: A WordPress plugin that allows editing a LESS file from the WP back-end.
Author: Jason Lengstorf
Author URI: http://lengstorf.com/
License: GPL v3

WordPress LESS Editor Plugin
Copyright (C) 2014, Jason Lengstorf — jason@lengstorf.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('DB_NAME')) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

if (!defined('WPLESS_PATH')) {
    define('WPLESS_PATH', plugin_dir_path(__FILE__));
}

if (!defined('WPLESS_BASENAME')) {
    define('WPLESS_BASENAME', plugin_basename(__FILE__));
}

define('WPLESS_FILE', __FILE__);

define( 'WPLESS_VERSION', '0.0.1b' );

function wpless_init(  ) {
    if (is_admin()) {
        require_once WPLESS_PATH . 'admin/class.wpless_admin.inc.php';
        $wpless = new WPLESS_Admin;
    } else {
        require_once WPLESS_PATH . 'frontend/class.wpless_frontend.inc.php';
        $wpless = new WPLESS_FrontEnd;
    }
}

wpless_init();
