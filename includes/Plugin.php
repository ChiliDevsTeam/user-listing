<?php
/**
 * Main plugin class.
 *
 * Setup and bootstrap everything from here.
 *
 * @package RtCamp\GithubLogin
 * @since 1.0.0
 */

declare(strict_types=1);

namespace ChiliDevs\UserListing;

/**
 * Class Plugin.
 *
 * @package RtCamp\GithubLogin
 */
class Plugin {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * Plugin directory path.
	 *
	 * @var string
	 */
	public $path;

	/**
	 * Plugin's url.
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Assets directory path.
	 *
	 * @var string
	 */
	public $template_dir;

	/**
	 * DI Container.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * List of active modules.
	 *
	 * @var string[]
	 */
	public $active_modules = [
		'rest_api',
		'listing',
	];

	/**
	 * Run the plugin
	 *
	 * @return void
	 */
	public function run(): void {
		$this->path         = dirname( __FILE__, 2 );
		$this->url          = plugin_dir_url( trailingslashit( dirname( __FILE__, 2 ) ) . 'login-with-google.php' );
		$this->template_dir = trailingslashit( $this->path ) . 'templates/';

		add_action( 'init', [ $this, 'load_translations' ] );

		$this->container()->define_services();
		$this->activate_modules();
	}

	/**
	 * Load the plugin translation.
	 *
	 * @return void
	 */
	public function load_translations(): void {
		load_plugin_textdomain( 'user-listing', false, basename( plugin()->path ) . '/languages/' . get_locale() );
	}

	/**
	 * Return container object.
	 *
	 * @return Container
	 */
	public function container(): Container {
		//phpcs:disable Squiz.PHP.DisallowMultipleAssignments.Found
		return $this->container = $this->container ?? new Container();
	}

	/**
	 * Activate individual modules.
	 *
	 * @return void
	 */
	private function activate_modules(): void {
		foreach ( $this->active_modules as $module ) {
			$module_instance = $this->container()->get( $module );
			$module_instance->init();
		}
	}

}
