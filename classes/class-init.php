<?php
/**
 * Core plugin class
 *
 * @package MP_Install
 * @subpackage Includes
 * @since 1.0.0
 */

namespace MP_Install\Includes;

final class Init {

	/**
	 * Instance of the class
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object Returns the instance.
	 */
	public static function instance() {

		// Varialbe for the instance to be used outside the class.
		static $instance = null;

		if ( is_null( $instance ) ) {

			// Set variable for new instance.
			$instance = new self;

			// Require the core plugin class files.
			$instance->dependencies();

		}

		// Return the instance.
		return $instance;

	}

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

	}

	/**
	 * Require the core plugin class files.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void Gets the file which contains the core plugin class.
	 */
	private function dependencies() {

		// 
		require_once MPI_PATH . 'classes/class-settings.php';

		// 
		require_once MPI_PATH . 'classes/class-mp-install.php';

		// 
		require_once MPI_PATH . 'classes/class-admin.php';

	}

}