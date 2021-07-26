import { __ } from '@wordpress/i18n';

const SingleUser = () => {
	return (
		<div>
			<h1 className="wp-heading-inline">
				{ __( 'Users #id', 'user-listing' ) }
			</h1>
			<p>Thisi s a single user</p>
		</div>
	);
}

export default SingleUser;
