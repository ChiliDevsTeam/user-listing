<?php
/**
 * Interface Module.
 *
 * Every module inside src/Modules/ should implement
 * to this interface.
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
interface Module {

	/**
	 * Initialization of module.
	 *
	 * @return void
	 */
	public function init(): void;

	/**
	 * Return module name.
	 *
	 * @return string
	 */
	public function name(): string;
}
