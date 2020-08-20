<?php
/**
 * Admin UI class
 *
 * @package MP_Install
 * @subpackage Admin
 * @since 1.0.0
 */

namespace MP_Install\Admin;

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

		$this->help_admin_page = add_submenu_page(
			'plugins.php',
			__( 'Install Multiple Plugins', MPI_DOMAIN ),
			__( 'Install Multiple', MPI_DOMAIN ),
			'manage_options',
			'mpinstaller',
			[ $this, 'page_output' ]
		);

		// Add content to the Help tab.
		add_action( 'load-' . $this->help_admin_page, [ $this, 'help_admin_page' ] );
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

	/**
	 * Add tabs to the about page contextual help section.
	 *
	 * @since      1.0.0
	 */
	public function help_admin_page() {

		// Add to the about page.
		$screen = get_current_screen();
		if ( $screen->id != $this->help_admin_page ) {
			return;
		}

		// More information tab.
		$screen->add_help_tab( [
			'id'       => 'help_plugin_info',
			'title'    => __( 'About Plugin', MPI_DOMAIN ),
			'content'  => null,
			'callback' => [ $this, 'help_plugin_info' ]
		] );

		// Convert plugin tab.
		$screen->add_help_tab( [
			'id'       => 'help_plugin_backup',
			'title'    => __( 'Backup Plugins', MPI_DOMAIN ),
			'content'  => null,
			'callback' => [ $this, 'help_plugin_backup' ]
		] );

		// Add a help sidebar.
		$screen->set_help_sidebar(
			$this->help_admin_page_sidebar()
		);

	}

	/**
	 * Get more information help tab content.
	 *
	 * @since      1.0.0
	 */
	public function help_plugin_info() {

		include_once MPI_PATH . 'views/help/help-plugin-info.php';

	}

	/**
	 * Get convert plugin help tab content.
	 *
	 * @since      1.0.0
	 */
	public function help_plugin_backup() {

		include_once MPI_PATH . 'views/help/help-plugin-backup.php';

	}

	/**
	 * The about page contextual tab sidebar content.
	 *
	 * @since      1.0.0
	 */
	public function help_admin_page_sidebar() {

		$html  = sprintf(
			'<h4>%1s</h4>',
			esc_html__( 'Plugin Version', MPI_DOMAIN )
		);
		$html .= sprintf(
			'<p>%1s %2s</p>',
			esc_html__( 'Current version of this plugin is', MPI_DOMAIN ),
			MPI_VERSION
		);
		$html .= sprintf(
			'<p>%1s <br /><a href="%2s" target="_blank" rel="noindex nofollow">%3s</a> <br />%4s</p>',
			esc_html__( 'Visit:', MPI_DOMAIN ),
			esc_url( 'https://github.com/antibrand/mp-install' ),
			esc_url( 'https://github.com/antibrand/mp-install' ),
			esc_html__( 'for the latest version.', MPI_DOMAIN )
		);

		return $html;

	}

}

// New instance of the class.
new Admin();