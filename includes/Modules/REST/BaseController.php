<?php
/**
 * Abstract class BaseController.
 *
 * @package ChiliDevs\UserListing
 * @since 1.0.0
 */

namespace ChiliDevs\UserListing\Modules\REST;

use WP_REST_Controller;
use WP_REST_Response;


/**
 * Class BaseController.
 *
 * @package ChiliDevs\UserListing\REST
 */
class BaseController extends WP_REST_Controller {

	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'wpul/v1';

	/**
	 * Format collection response with pagination.
	 *
	 * @param WP_REST_Response $response Rest Respone object.
	 * @param WP_REST_Request  $request Rest request object.
	 * @param int              $total_items Count total items.
	 *
	 * @return WP_REST_Response
	 */
	public function format_collection_response( $response, $request, $total_items ): WP_REST_Response {
		if ( 0 === $total_items ) {
			return $response;
		}

		// Store pagation values for headers then unset for count query.
		$per_page = (int) ( ! empty( $request['per_page'] ) ? $request['per_page'] : 20 );
		$page     = (int) ( ! empty( $request['page'] ) ? $request['page'] : 1 );

		$response->header( 'X-WP-Total', (int) $total_items );

		$max_pages = ceil( $total_items / $per_page );

		$response->header( 'X-WP-TotalPages', (int) $max_pages );
		$base = add_query_arg( $request->get_query_params(), rest_url( sprintf( '/%s/%s', $this->namespace, $this->rest_base ) ) );

		if ( $page > 1 ) {
			$prev_page = $page - 1;

			if ( $prev_page > $max_pages ) {
				$prev_page = $max_pages;
			}

			$prev_link = add_query_arg( 'page', $prev_page, $base );
			$response->link_header( 'prev', $prev_link );
		}

		if ( $max_pages > $page ) {
			$next_page = $page + 1;
			$next_link = add_query_arg( 'page', $next_page, $base );
			$response->link_header( 'next', $next_link );
		}

		return $response;
	}

}

