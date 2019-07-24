<?php
/**
 * Plugin Name: JetGetRemotePosts
 * Plugin URI:
 * Description: Get posts from remote site by API
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:
 * Text Domain: jet-remote-posts
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

add_action( 'init', 'jet_get_remote_posts_init' );

function jet_get_remote_posts_init() {

	define( 'JET_GRP_VERSION', '1.0.0' );

	define( 'JET_GRP__FILE__', __FILE__ );
	define( 'JET_GRP_PLUGIN_BASE', plugin_basename( JET_GRP__FILE__ ) );
	define( 'JET_GRP_PATH', plugin_dir_path( JET_GRP__FILE__ ) );
	define( 'JET_GRP_URL', plugins_url( '/', JET_GRP__FILE__ ) );

	require JET_GRP_PATH . 'includes/plugin.php';

}

function jet_get_remote_posts() {
	return JET_GRP\Plugin::instance();
}
