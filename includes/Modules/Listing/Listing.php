<?php
/**
 * Users REST Container class.
 *
 * Load All
 *
 * @package ChiliDevs\UserListing
 * @since 1.0.0
 */

declare(strict_types=1);

namespace ChiliDevs\UserListing\Modules\Listing;

use ChiliDevs\UserListing\Interfaces\Module;

use function ChiliDevs\UserListing\plugin;

/**
 * Class Listing.
 *
 * @package ChiliDevs\UserListing\Modules
 */
class Listing implements Module {

	/**
	 * Get module name.
	 *
	 * @return string
	 */
	public function name(): string {
		return $this->name;
	}

	/**
	 * Load class hooks
	 *
	 * @return void
	 */
	public function init(): void {
		$this->name = 'listing';

		add_action( 'admin_menu', [ $this, 'menu' ], 10 );
		add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );
	}

	/**
	 * Load admin menu
	 *
	 * @return void
	 */
	public function menu(): void {
		add_menu_page(
			__( 'User Listing', 'user-listing' ),
			__( 'User Listing', 'user-listing' ),
			'manage_options',
			'wp-user-listing',
			[ $this, 'content' ]
		);
	}

	/**
	 * Load menu content
	 *
	 * @return void
	 */
	public function content(): void {
		echo '<div id="wp-user-listing"></div>';
	}

	/**
	 * Load scripts and styles
	 *
	 * @return void
	 */
	public function assets(): void {
		$dependency = require_once plugin()->path . '/build/listing.asset.php';

		wp_register_script(
			'wp-user-listing-script',
			trailingslashit( plugin()->url ) . 'build/listing.js',
			$dependency['dependencies'],
			$dependency['version'],
			true
		);

		if ( ! empty( $_GET['page'] ) && 'wp-user-listing' === $_GET['page'] ) {
			wp_enqueue_script( 'wp-user-listing-script' );
		}
	}

}
