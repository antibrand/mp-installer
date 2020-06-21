<?php
/**
 * MP Installer
 *
 * @package MP_Installer
 * @version 1.0.0
 * @link    https://github.com/antibrand/mp-installer
 *
 * Plugin Name: mp-installer
 * Plugin URI: https://github.com/antibrand/mp-installer
 * Description: Install and activate multiple plugins at once.
 * Version: 1.0.0
 * Author:
 * Author URI:
 * Text Domain:  mp-installer
 * Domain Path:  /languages
 * Tested up to:
*/

/**
 * Plugin version
 *
 * Keeping the version at 1.0.0 as this is a starter plugin but
 * you may want to start counting as you develop for your use case.
 *
 * @since  1.0.0
 * @return string Returns the latest plugin version.
 */
if ( ! defined( 'MPI_VERSION' ) ) {
	define( 'MPI_VERSION', '1.0.0' );
}

/**
 * Plugin directory path
 *
 * @since  1.0.0
 * @return string Returns the filesystem directory path (with trailing slash)
 *                for the plugin __FILE__ passed in.
 */
if ( ! defined( 'MPI_PATH' ) ) {
	define( 'MPI_PATH', plugin_dir_path( __FILE__ ) );
}

/**
 * Uploads directory
 *
 * @since  1.0.0
 * @return string Returns the filesystem directory path (with trailing slash)
 *                for the uploads directory.
 */
$mpi_upload_dir = wp_upload_dir();
if ( ! defined( 'MPI_UPLOAD_DIR_PATH' ) ) {
	define( 'MPI_UPLOAD_DIR_PATH', $mpi_upload_dir['basedir'] );
}

/**
 * App plugins directory
 *
 * @since  1.0.0
 * @return string Returns the filesystem directory path (with trailing slash)
 *                for the directory of plugin __FILE__ passed in.
 */
if ( ! defined( 'MPI_APP_PLUGIN_DIR' ) ) {
	define( 'MPI_APP_PLUGIN_DIR', dirname( plugin_dir_path( __FILE__ ) ) );
}

/**
 * Plugin directory URL
 *
 * @since  1.0.0
 * @return string Returns the URL directory path (with trailing slash)
 *                for the plugin __FILE__ passed in.
 */
if ( ! defined( 'MPI_URL' ) ) {
	define( 'MPI_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Text domain
 *
 * @since  1.0.0
 * @return string Returns the text domain of the plugin.
 */
if ( ! defined( 'MPI_DOMAIN' ) ) {
	define( 'MPI_DOMAIN', 'mp-installer' );
}

load_plugin_textdomain(
	MPI_DOMAIN,
	false,
	dirname( plugin_basename( __FILE__ ) ) . '/languages/'
);

// Require core plugin class.
require_once( 'classes/class-mp-installer.php' );
use MP_Installer\Includes as Includes;
$instance = new Includes\MP_Installer();

// Admin menu hook
add_action( 'admin_init', 'mpi_download_backup' );
add_action( 'admin_init', 'mpi_delete_backup' );

function mpi_download_backup() {

	if ( isset( $_GET['dn'] ) ) {

		if ( trim( $_GET['dn'] ) && $_GET['dn'] == 1 ) {
			$instance = new Includes\MP_Installer();
			$instance->mpi_download();
		}
	}

}

function mpi_delete_backup() {

	if ( isset( $_GET['dl'] ) ) {

		if ( trim( $_GET['dl'] ) && $_GET['dl'] ==1 ) {
			$instance = new Includes\MP_Installer();
			$instance->mpi_delete();
		}
	}
}

function mpi_activation() {

	if ( ! is_dir( MPI_UPLOAD_DIR_PATH . '/mp-installer-logs' ) ) {
		@mkdir( MPI_UPLOAD_DIR_PATH . '/mp-installer-logs', 0777 );
	}

	if ( ! is_dir( MPI_UPLOAD_DIR_PATH . '/mp-installer-logs/files' ) ) {
		@mkdir( MPI_UPLOAD_DIR_PATH . '/mp-installer-logs/files', 0777 );
	}

	if ( ! is_dir( MPI_UPLOAD_DIR_PATH . '/mp-installer-logs/files/tmp' ) ) {
		@mkdir( MPI_UPLOAD_DIR_PATH . '/mp-installer-logs/files/tmp', 0777 );
	}
}
register_activation_hook( __FILE__, 'mpi_activation' );

// Get version.
function mpi_get_version() {

	if ( ! function_exists( 'get_plugins' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file   = basename( ( __FILE__ ) );

	return $plugin_folder[$plugin_file]['Version'];
}
