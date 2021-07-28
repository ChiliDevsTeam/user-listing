<?php
/**
 * User model class.
 *
 * A model for a user.
 *
 * @package ChiliDevs\UserListing
 * @since 1.0.0
 */

declare(strict_types=1);

namespace ChiliDevs\UserListing\Models;

use WP_User;

use function ChiliDevs\UserListing\plugin;

/**
 * User model.
 *
 * @package ChiliDevs\UserListing
 */
class User {

	/**
	 * User id.
	 *
	 * @var int
	 */
	protected $id;

	/**
	 * User utils.
	 *
	 * @var object
	 */
	protected $user_utils;

	/**
	 * Stores customer data.
	 *
	 * @var array
	 */
	protected $data = [
		'id'              => 0,
		'username'        => '',
		'first_name'      => '',
		'last_name'       => '',
		'full_name'       => '',
		'avatar'          => [],
		'email'           => '',
		'website'         => '',
		'nicename'        => '',
		'display_name'    => '',
		'roles'           => [],
		'status'          => 0,
		'registered_date' => '',
		'type'            => '',
	];

	/**
	 * WP User data.
	 *
	 * @var WP_User|null
	 */
	private $wp_user = null;

	/**
	 * Contructor function.
	 *
	 * @param mixed $data User data.
	 */
	public function __construct( $data = 0 ) {
		$this->user_utils = plugin()->container()->get( 'user_utils' );

		if ( $data instanceof User ) {
			$this->set_id( absint( $data->get_id() ) );
			$this->data = $data->data;
		} elseif ( is_numeric( $data ) ) {
			$this->set_id( absint( $data ) );
			$this->populate_data( absint( $data ) );
		}
	}

	/**
	 * Set Id.
	 *
	 * @param int $id user id.
	 */
	public function set_id( int $id ): void {
		$this->id         = $id;
		$this->data['id'] = $id;
	}

	/**
	 * Populate the user object.
	 *
	 * @param int $id User id.
	 *
	 * @return void
	 */
	public function populate_data( int $id ): void {
		$this->wp_user = get_user_by( 'id', $id );

		if ( ! empty( $this->wp_user ) ) {
			foreach ( $this->data as $key => $value ) {
				$this->data[ $key ] = is_callable( array( $this, "get_{$key}" ) ) ? $this->{"get_{$key}"}() : '';
			}
		}
	}

	/**
	 * Get all data from properties.
	 *
	 * @return array
	 */
	public function get_data(): array {
		return $this->data;
	}

	/**
	 * Get user id
	 *
	 * @return int
	 */
	public function get_id(): int {
		return absint( $this->wp_user->ID );
	}

	/**
	 * Get username
	 *
	 * @return string
	 */
	public function get_username(): string {
		return $this->wp_user->user_login;
	}

	/**
	 * Get first name
	 *
	 * @return string
	 */
	public function get_first_name(): string {
		return $this->wp_user->first_name;
	}

	/**
	 * Get last name
	 *
	 * @return string
	 */
	public function get_last_name(): string {
		return $this->wp_user->last_name;
	}

	/**
	 * Get full name
	 *
	 * @return string
	 */
	public function get_full_name(): string {
		if ( ! empty( $this->wp_user->first_name ) ) {
			$full_name = $this->wp_user->first_name . ' ' . $this->wp_user->last_name;
		} else {
			$full_name = $this->wp_user->display_name;
		}
		return trim( $full_name );
	}

	/**
	 * Get avatar
	 *
	 * @param int $size Size of avatar.
	 *
	 * @return array
	 */
	public function get_avatar( $size = 32 ): array {

		/**
		 * Filter for getting user avatar.
		 *
		 * @param object $this->wp_user WP User Object.
		 */
		return apply_filters( 'wpul_get_user_avatar', [
			'img' => get_avatar( $this->wp_user->email, $size ),
			'url' => get_avatar_url( $this->wp_user->email, [ 'size' => $size ] ),
		], $this->wp_user );
	}

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function get_email(): string {
		return $this->wp_user->user_email;
	}

	/**
	 * Get website
	 *
	 * @return string
	 */
	public function get_website(): string {
		return $this->wp_user->user_url;
	}

	/**
	 * Get nicename
	 *
	 * @return string
	 */
	public function get_nicename(): string {
		return $this->wp_user->user_nicename;
	}

	/**
	 * Get display name
	 *
	 * @return string
	 */
	public function get_display_name(): string {
		return $this->wp_user->display_name;
	}

	/**
	 * Get roles
	 *
	 * @return array
	 */
	public function get_roles(): array {
		return $this->user_utils->get_role_list( $this->wp_user );
	}

	/**
	 * Get status
	 *
	 * @return bool
	 */
	public function get_status(): bool {
		return wp_validate_boolean( $this->wp_user->user_status );
	}

	/**
	 * Get registerd_date
	 *
	 * @return string
	 */
	public function get_registered_date(): string {
		return $this->wp_user->user_registered;
	}

	/**
	 * Get type
	 *
	 * @return string
	 */
	public function get_type(): string {
		return 'wp_user';
	}

}


