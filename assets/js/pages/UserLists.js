import { __ } from '@wordpress/i18n';
import ListTable from 'jsPath/components/ListTable';
import { UserProvider } from 'jsPath/context/UserContext';

const UserLists = () => {

	return (
		<>
			<h1 className="wp-heading-inline">
				{ __( 'Users', 'user-listing' ) }
			</h1>
			<UserProvider>
				<ListTable></ListTable>
			</UserProvider>
		</>
	);
}

export default UserLists;
