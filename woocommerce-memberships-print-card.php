<?php
/**
 * Plugin Name: WooCommerce Memberships Print Card
 * Plugin URI: https://www.virtulizate.com.co/products/woocommerce-memberships/
 * Documentation URI: https://docs.virtulizate.com.co/document/woocommerce-memberships/
 * Description: @todo Something
 * Author: Grupo Virtualizate
 * Author URI: https://www.virtulizate.com.co/
 * Version: 0.1.0
 * Text Domain: woocommerce-memberships-print-card
 * Domain Path: /i18n/languages/
 *
 * Copyright: (c) 2020 Grupo Virtualizate, Inc. (soporte@virtualizate.com.co)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @author    Grupo Virtualizate
 * @copyright Copyright (c) 2014-2020, Grupo Virtualizate. (soporte@virtualizate.com.co)
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 *
 * WC requires at least: 3.0.9
 * WC tested up to: 4.5.2
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define statics options for core plugin
 */
define('DS', DIRECTORY_SEPARATOR);
define('WMPC_VERSION', '0.1.0');
define('WMPC_SLUG', 'woocommerce-memberships-print-card');
define('WMPC_CAPABILITY', 'manage_options');
define('WMPC_PREFIX', 'wpmc');
define('WMPC_URL', untrailingslashit(plugin_dir_url(__FILE__)));
define('WMPC_PATH', untrailingslashit(plugin_dir_path(__FILE__)));
define('WMPC_SCRIPTS_URL', WMPC_URL . DS . 'assets' );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require( __DIR__ . '/vendor/autoload.php' );
}

\WMPC\WMPC::run();