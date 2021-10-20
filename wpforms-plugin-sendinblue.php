<?php
/**
 * Plugin Name: SendinBlue plugin for WPForms
 * Plugin URI:  https://github.com/GeorgHenkel/wpforms-plugin-sendinblue
 * Description: Connect WPForms with SendinBlue API
 * Version:     1.0.2
 * Author:      Georg Leber
 * Author URI:  https://www.georg-leber.de
 * Text Domain: wpforms-plugin-sendinblue
 * Domain Path: /languages
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3, as published by the
 * Free Software Foundation. You may NOT assume that you can use any other
 * version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.
 *
 * @package    WPForms_Plugin_SendinBlue
 * @since      1.0.0
 * @copyright  Copyright (c) 2021, Georg Leber
 * @license    GPL-3.0+
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Plugin version
define( 'WPFORMS_PLUGIN_SENDINBLUE_VERSION', '1.0.0' );

/**
 * Load the class
 *
 */
function wpforms_plugin_sendinblue() {

    load_plugin_textdomain( 'wpforms-plugin-sendinblue', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    require_once( plugin_dir_path( __FILE__ ) . 'class-wpforms-plugin-sendinblue.php' );

}
add_action( 'wpforms_loaded', 'wpforms_plugin_sendinblue' );
