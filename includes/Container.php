<?php
/**
 * Class Container.
 *
 * This will be useful for creation of object.
 * We are using Pimple DI Container, which will be
 * useful for defining services and serves as service
 * locator.
 *
 * @package RtCamp\GithubLogin
 * @since 1.0.0
 */

declare(strict_types=1);

namespace ChiliDevs\UserListing;

use ChiliDevs\UserListing\Modules\Listing\Listing;
use InvalidArgumentException;
use Pimple\Container as PimpleContainer;
use ChiliDevs\UserListing\Modules\REST\Api;
use ChiliDevs\UserListing\Modules\REST\ApiContainer;

/**
 * Container class
 *
 * @package ChiliDevs\UserListing
 */
class Container {

	/**
	 * Pimple container.
	 *
	 * @var PimpleContainer
	 */
	private $container;

	/**
	 * Get the service object.
	 *
	 * @param string $service Service object in need.
	 *
	 * @return object
	 *
	 * @throws InvalidArgumentException Exception for invalid service.
	 */
	public function get( string $service ): object {
		if ( ! in_array( $service, $this->container->keys() ) ) {
			/* translators: %$s is replaced with requested service name. */
			throw new InvalidArgumentException( sprintf( __( 'Invalid Service %s Passed to the container', 'user-listing' ), $service ) );
		}

		return $this->container[ $service ];
	}

	/**
	 * Define common services in container.
	 *
	 * All the module specific services will be defined inside
	 * respective module's container.
	 *
	 * @return void
	 */
	public function define_services(): void {
		$this->container = new PimpleContainer();

		/**
		 * Define REST API service
		 *
		 * @param PimpleContainer $c Pimple container object.
		 *
		 * @return ApiContainer
		 */
		$this->container['rest_api'] = function( PimpleContainer $c ) {
			return new ApiContainer();
		};

		/**
		 * Define Listing service
		 *
		 * @param PimpleContainer $c Pimple container object.
		 *
		 * @return Listing
		 */
		$this->container['listing'] = function( PimpleContainer $c ) {
			return new Listing();
		};
	}
}

