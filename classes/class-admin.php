<?php
/**
 * Admin UI class
 *
 * @package MP_Installer
 * @subpackage Admin
 * @since 1.0.0
 */

namespace MP_Installer\Admin;

class Admin {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
    public function __construct() {

		// Enqueue styles & scripts.
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

		// Add admin page.
		add_action( 'admin_menu', [ $this, 'admin_page' ] );
	}

	/**
	 * Enqueue styles & scripts
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_scripts() {

		if ( is_admin() ) {

			if ( isset( $_REQUEST['page'] ) && 'mpinstaller' == $_REQUEST['page'] ) {

				wp_enqueue_script ( 'jquery' );
				wp_enqueue_script( 'mpi-admin',  MPI_URL . 'assets/js/mpi-admin.min.js', [ 'jquery' ], MPI_VERSION, true );
				wp_enqueue_style( 'mpi-admin', MPI_URL . 'assets/css/admin.min.css', [], MPI_VERSION, 'all' );
			}
		}
	}

	/**
	 * Admin page
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_page() {

		add_submenu_page(
			'plugins.php',
			__( 'Install Multiple Plugins', MPI_DOMAIN ),
			__( 'Install Multiple', MPI_DOMAIN ),
			'manage_options',
			'mpinstaller',
			[ $this, 'page_output' ]
		);
	}

	/**
	 * Admin page output
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function page_output() {
		require_once( MPI_PATH . 'views/admin.php' );
	}

}

// New instance of the class.
new Admin();