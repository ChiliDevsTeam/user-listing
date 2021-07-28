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

namespace ChiliDevs\UserListing\Utils;

/**
 * UserUtils class.
 *
 * @package ChiliDevs\UserListing\Utils
 */
class UserUtils {

	/**
	 * Returns an array of user roles for a given user object.
	 *
	 * @param WP_User $user_object The WP_User object.
	 *
	 * @return string[] An array of user roles.
	 */
	public function get_role_list( $user_object ): array {
		$wp_roles = wp_roles();

		$role_list = array();

		foreach ( $user_object->roles as $role ) {
			if ( isset( $wp_roles->role_names[ $role ] ) ) {
				$role_list[ $role ] = translate_user_role( $wp_roles->role_names[ $role ] );
			}
		}

		if ( empty( $role_list ) ) {
			$role_list['none'] = _x( 'None', 'no user roles' );
		}

		/**
		 * Filters the returned array of roles for a user.
		 *
		 * @since 4.4.0
		 *
		 * @param string[] $role_list   An array of user roles.
		 * @param WP_User  $user_object A WP_User object.
		 */
		return apply_filters( 'wpul_get_role_list', $role_list, $user_object );
	}
}

