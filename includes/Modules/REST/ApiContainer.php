<?php
/**
 * API Container class.
 *
 * Setup and bootstrap all API enpoint instance
 *
 * @package ChiliDevs\UserListing
 * @since 1.0.0
 */

declare(strict_types=1);

namespace ChiliDevs\UserListing\Modules\REST;

use ChiliDevs\UserListing\Interfaces\Module;

/**
 * Class ApiContainer.
 *
 * @package ChiliDevs\UserListing\REST
 */
class ApiContainer implements Module {

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
		$this->name = 'rest_api';

		add_action( 'rest_api_init', [ $this, 'register_rest_routes' ], 10 );
	}

	/**
	 * Register all rest routes
	 *
	 * @return void
	 */
	public function register_rest_routes(): void {
		foreach ( $this->map_classes() as $class ) {
			$controller = new $class();
			$controller->register_routes();
		}
	}

	/**
	 * Register all classes for load rest routes
	 *
	 * @return array
	 */
	public function map_classes(): array {
		return [
			UsersController::class,
		];
	}

}
