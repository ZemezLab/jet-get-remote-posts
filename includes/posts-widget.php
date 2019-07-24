<?php
namespace JET_GRP;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Posts_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'jet-grp-posts';
	}

	public function get_title() {
		return 'Get Remote Posts';
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return array( 'basic' );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_general',
			array(
				'label' => 'General',
			)
		);

		$this->add_control(
			'api_url',
			array(
				'label'       => 'Website URL',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'Website URL to get posts from',
				'default'     => '',
				'label_block' => true,
			)
		);

		$this->add_control(
			'number',
			array(
				'label'       => 'Posts number to get',
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 3,
			)
		);

		$this->add_control(
			'trim_title',
			array(
				'label'       => 'Trim title (leave 0 to show full)',
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 0,
			)
		);

		$this->add_control(
			'force_update',
			array(
				'label'       => 'Force to get posts from remote (ignore cache)',
				'type'        => \Elementor\Controls_Manager::SWITCHER,
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings     = $this->get_settings();
		$api_url      = ! empty( $settings['api_url'] ) ? $settings['api_url'] : '';
		$number       = ! empty( $settings['number'] ) ? $settings['number'] : '';
		$trim_title   = ! empty( $settings['trim_title'] ) ? $settings['trim_title'] : '';
		$force_update = ! empty( $settings['force_update'] ) ? $settings['force_update'] : '';

		if ( ! $api_url ) {
			return;
		}

		echo $this->remote_get_posts( $api_url, $number, $trim_title, $force_update );

	}

	/**
	 * Returns remote posts
	 *
	 * @param  [type] $api_url [description]
	 * @param  [type] $number  [description]
	 * @return [type]          [description]
	 */
	public function remote_get_posts( $api_url, $number, $trim_title, $force_update ) {

		$hash   = md5( $api_url . $number . $trim_title );
		$cached = get_transient( $hash );

		if ( $force_update ) {
			$cached = false;
		}

		if ( ! $cached ) {

			$api_url  = trailingslashit( $api_url );
			$response = wp_remote_get( $api_url . 'wp-json/wp/v2/posts/?context=embed&per_page=' . $number );
			$body     = wp_remote_retrieve_body( $response );

			if ( ! $body ) {
				return;
			}

			$body = json_decode( $body, true );

			if ( empty( $body ) ) {
				return;
			}

			ob_start();

			include JET_GRP_PATH . 'templates/loop-start.php';

			foreach ( $body as $item ) {
				include JET_GRP_PATH . 'templates/loop-item.php';
			}

			include JET_GRP_PATH . 'templates/loop-end.php';

			$cached = ob_get_clean();

			set_transient( $hash, $cached, 4 * HOUR_IN_SECONDS );

		}

		return $cached;

	}

	protected function _content_template() {}

}
