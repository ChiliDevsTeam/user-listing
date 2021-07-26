<?php
/**
 * Interface Api.
 *
 * Every rest controller must have this methods
 *
 * @package ChiliDevs\UserListing
 * @since 1.0.0
 */

namespace ChiliDevs\UserListing\Interfaces;

/**
 * Interface Module
 *
 * @package DigitalRiver\WooCommerce
 */
interface ApiInterface {

	/**
	 * Initialization all routes.
	 *
	 * @return void
	 */
	public function register_routes(): void;
}
