import { useEffect } from "react";
import apiFetch from "@wordpress/api-fetch";

import FilterNav from './FilterNav';
import Pagination from './Pagination';
import TableHeaderFooter from './TableHeaderFooter';
import TableBody from './TableBody';
import { useUserContext } from 'jsPath/context/UserContext';

const ListTable = () => {
	const { dispatch } = useUserContext();

	const fetchUsers = async () => {
		dispatch( { type: 'FETCH_USERS_LOADING' } );

		await apiFetch( { path: '/wpul/v1/users', parse: false } ).then( ( response ) => {
			let totalPage = response.headers.get( 'X-WP-TotalPages' );
			let totalUsers = response.headers.get( 'X-WP-Total' );

			dispatch( { type: 'FETCH_USERS_HEADER', payload: { totalPage, totalUsers } } );

			return response.json();
		} ).then( ( users ) => {

			dispatch( { type: 'FETCH_USERS', payload: users } );

		} ).catch( ( errors ) => {

			dispatch( { type: 'FETCH_USERS_ERRORS', payload: errors.message } );

		} );
	};

	useEffect( () => {
		let isMounted = true;

		if ( isMounted ) {
			fetchUsers();
		}
		return () => { isMounted = false };
	}, [] );

	return (
		<>
			<div className="tablenav top">
				<FilterNav></FilterNav>
				<Pagination></Pagination>
			</div>
			<table className="wp-list-table widefat fixed striped users">
				<TableHeaderFooter type={'header'}></TableHeaderFooter>
				<TableHeaderFooter></TableHeaderFooter>
				<TableBody></TableBody>
			</table>
			<div className="tablenav bottom">
				<Pagination></Pagination>
			</div>
		</>
	);
}

export default ListTable;
