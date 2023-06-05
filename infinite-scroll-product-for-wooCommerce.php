<?php
/**
 * Plugin Name:       Infinite Scroll Product For WooCommerce
 * Plugin URI:        https://github.com/Faridmia/infinite-scroll-product-for-woocommerce
 * Description:       The Infinite Scroll Product For WooCommerce is a powerful tool designed to enhance the browsing experience and improve the performance of online stores built with WooCommerce. It provides seamless and dynamic scrolling functionality, allowing customers to browse through product listings without the need for traditional pagination.
 * Version:           1.0.0
 * Author:            faridmia
 * Author URI:        https://profiles.wordpress.org/faridmia/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       infinite-scroll-woo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Defines CONSTANTS for Whole plugins.
 */
define( 'INFINITE_ISPFW_WOO_FILE', __FILE__ );
define( 'INFINITE_ISPFW_WOO_VERSION', '1.0.0' );
define( 'INFINITE_ISPFW_WOO_URL', plugins_url( '/', __FILE__ ) );
define( 'INFINITE_ISPFW_WOO_PATH', plugin_dir_path( __FILE__ ) );
define( 'INFINITE_ISPFW_WOO_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'INFINITE_ISPFW_WOO_BASENAME', plugin_basename( __FILE__ ) );

define( 'INFINITE_ISPFW_WOO_ASSETS', INFINITE_ISPFW_WOO_URL );
define( 'INFINITE_ISPFW_WOO_ASSETS_PATH', INFINITE_ISPFW_WOO_PATH );
define( 'INFINITE_ISPFW_WOO_INCLUDES', INFINITE_ISPFW_WOO_PATH . 'includes/' );

define( 'INFINITE_ISPFW_WOO_ADMIN_URL', INFINITE_ISPFW_WOO_ASSETS . 'admin/' );
define( 'INFINITE_ISPFW_WOO_PUBLIC_URL', INFINITE_ISPFW_WOO_ASSETS . 'public/' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-advanced-infinite-scroll-woo-activator.php
 */
function activate_infinite_sp_woo() {
	require_once INFINITE_ISPFW_WOO_PATH . 'includes/class-infinite-scrolling-woo-activator.php';
	Infinite_Ispfw_Woo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-advanced-infinite-scroll-woo-deactivator.php
 */
function deactivate_infinite_sp_woo() {
	require_once INFINITE_ISPFW_WOO_PATH . 'includes/class-infinite-scrolling-woo-deactivator.php';
	Infinite_Ispfw_Woo_Deactivator::deactivate();
}

register_activation_hook( INFINITE_ISPFW_WOO_FILE, 'activate_infinite_sp_woo' );
register_deactivation_hook( INFINITE_ISPFW_WOO_FILE, 'deactivate_infinite_sp_woo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require INFINITE_ISPFW_WOO_PATH . 'includes/class-infinite-scrolling-woo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_infinite_ispfw_woo() {

	$plugin = new Infinite_Ispfw_Woo();
	$plugin->run();

}

function infinite_ispfw_woo_admin_notices() { ?>
	<div class="error">
        <p><?php _e( '<strong>Infinite Scroll Product For WooCommerce  requires WooCommerce to be installed and active. You can download <a href="https://woocommerce.com/" target="_blank">WooCommerce</a> here.</strong>', 'infinite-scroll-woo' ); ?></p>
    </div>
   	<?php
}
// woocommerce  plugin dependency
function infinite_Ispfw_woo_install_woocommerce_dependency() {
	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'infinite_ispfw_woo_admin_notices');
	}
}

add_action( 'plugins_loaded',  'infinite_Ispfw_woo_install_woocommerce_dependency' );

run_infinite_ispfw_woo();
