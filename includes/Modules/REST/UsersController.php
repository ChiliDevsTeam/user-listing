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

namespace ChiliDevs\UserListing\Modules\REST;

use ChiliDevs\UserListing\Models\User;
use WP_User_Query;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;

/**
 * UsersController class.
 *
 * @package ChiliDevs\UserListing\REST
 */
class UsersController extends BaseController {

	/**
	 * Route base.
	 *
	 * @var string
	 */
	protected $rest_base = 'users';

	/**
	 * Register all routes for users
	 *
	 * @return void
	 */
	public function register_routes(): void {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			[
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_users' ],
					'args'                => $this->get_collection_params(),
					'permission_callback' => function() {
						return current_user_can( 'manage_options' );
					},
				],
			]
		);
	}

	/**
	 * Get all users.
	 *
	 * @param WP_REST_Request $request Request object.
	 *
	 * @return WP_REST_Response
	 */
	public function get_users( WP_REST_Request $request ): WP_REST_Response {
		$params = $request->get_params();
		$args   = [
			'fields' => 'ID',
			'number' => $params['per_page'],
			'paged'  => $params['page'],
		];

		$users = new WP_User_Query( $args );

		$data = [];
		foreach ( $users->get_results() as $id ) {
			$item   = $this->prepare_item_for_response( new User( $id ), $request );
			$data[] = $this->prepare_response_for_collection( $item );
		}

		$response = rest_ensure_response( $data );
		return $this->format_collection_response( $response, $request, $users->get_total() );
	}

	/**
	 * Prepare data for response.
	 *
	 * @param mixed           $data WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 *
	 * @return WP_REST_Response|WP_Error
	 */
	public function prepare_item_for_response( $data, $request ) {
		$response = rest_ensure_response( $data->get_data() );
		$response->add_links( $this->prepare_links( $data->get_data(), $request ) );
		return apply_filters( 'wpul_rest_prepare_users_object', $response, $data, $request );
	}

	/**
	 * Prepare links for the request.
	 *
	 * @param array           $data Object data.
	 * @param WP_REST_Request $request Request object.
	 *
	 * @return array Links for the given post.
	 */
	protected function prepare_links( $data, WP_REST_Request $request ) {
		$links = [
			'self'       => [
				'href' => rest_url( sprintf( '/%s/%s/%d', $this->namespace, $this->rest_base, $data['id'] ) ),
			],
			'collection' => [
				'href' => rest_url( sprintf( '/%s/%s', $this->namespace, $this->rest_base ) ),
			],
		];

		return $links;
	}
}

