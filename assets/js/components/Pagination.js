import { useUserContext } from 'jsPath/context/UserContext';
import { useHistory, useLocation } from 'react-router-dom';

const Pagination = () => {
	const { totalUsers, totalPage } = useUserContext();
	const history = useHistory();
	const location = useLocation();

	/**
	 * Get current page
	 *
	 * @returns {int}
	 */
	const getCurrentPage = () => {
		const page = new URLSearchParams( location.search ).get( 'page' );

		if ( page ) {
			return Number( page );
		}

		return 1;
	}

	/**
	 * Check if first page.
	 *
	 * @returns {bool}
	 */
	const isFastPage = () => {
		return getCurrentPage() === 1;
	}

	/**
	 * Check if last page.
	 *
	 * @returns {bool}
	 */
	const isLastPage = () => {
		return getCurrentPage() === totalPage;
	}

	/**
	 * Get current query param as a object.
	 *
	 * @returns {object}
	 */
	const getQueryParams = () => {
		let params = {};

		const urlParams = new URLSearchParams( location.search );

		urlParams.forEach( ( value, key ) => {
			params[key] = value;
		});

		return params;
	}

	/**
	 * Append query string to url.
	 *
	 * @param {void}
	 */
	const goToPage = ( page ) => {
		const pageNumber = page;
		const queryParams = getQueryParams();
		const queryPath = { ...queryParams, page: pageNumber }
		var queryString = Object.keys( queryPath ).map( key => key + '=' + queryPath[key] ).join( '&' );

		if ( pageNumber ) {
			history.push( '?' + queryString );
		}
	}

	/**
	 * Get first navigation html.
	 *
	 * @returns {JXS}
	 */
	const firstPageNavigation = () => {
		if ( isFastPage() ) {
			return (
				<>
					<span className='tablenav-pages-navspan button disabled' aria-hidden='true'>&laquo;</span>
					<span className='tablenav-pages-navspan button disabled' aria-hidden='true'>&lsaquo;</span>
				</>
			)
		} else {
			return (
				<>
					<a className="next-page button" onClick={ () => goToPage( 1 ) } >
						<span className="screen-reader-text">First page</span>
						<span aria-hidden="true">&laquo;</span>
					</a>
					<a className="first-page button" onClick={ () => goToPage( getCurrentPage() - 1 ) }>
						<span className="screen-reader-text">Prev page</span>
						<span aria-hidden="true">&lsaquo;</span>
					</a>
				</>
			)
		}
	}

	/**
	 * Get last navigation html.
	 *
	 * @returns {JXS}
	 */
	const lastPageNavigation = () => {
		if ( isLastPage() ) {
			return (
				<>
					<span className='tablenav-pages-navspan button disabled' aria-hidden='true'>&rsaquo;</span>
					<span className='tablenav-pages-navspan button disabled' aria-hidden='true'>&raquo;</span>
				</>
			)
		} else {
			return (
				<>
					<a className="next-page button" onClick={ () => goToPage( getCurrentPage() + 1 ) }>
						<span className="screen-reader-text">Next page</span>
						<span aria-hidden="true">&rsaquo;</span>
					</a>
					<a className="last-page button" onClick={ () => goToPage( totalPage ) } >
						<span className="screen-reader-text">Last page</span>
						<span aria-hidden="true">&raquo;</span>
					</a>
				</>
			)
		}
	}

	return (
		<div className="tablenav-pages">
			<span className="displaying-num">{ totalUsers } items</span>
			<span className="pagination-links">
				{ firstPageNavigation() }

				<span id="table-paging" className="paging-input">
					<span className="tablenav-paging-text">{ getCurrentPage() } of <span className="total-pages">{ totalPage }</span></span>
				</span>

				{ lastPageNavigation() }
			</span>
		</div>
	)
}

export default Pagination;
