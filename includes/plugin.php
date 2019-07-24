<?php
namespace JET_GRP;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Main file
 */
class Plugin {

	/**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {

			self::$instance = new self();

		}

		return self::$instance;

	}

	/**
	 * Initialize remote posts widget
	 *
	 * @param  [type] $widgets_manager [description]
	 * @return [type]                  [description]
	 */
	public function init_widget( $widgets_manager ) {
		require JET_GRP_PATH . 'includes/posts-widget.php';
		$widgets_manager->register_widget_type( new Posts_Widget() );
	}

	/**
	 * Plugin constructor.
	 */
	private function __construct() {
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widget' ) );
	}

}

Plugin::instance();
