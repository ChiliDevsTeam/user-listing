const TableHeaderFooter = ( { type } ) => {
	const content = (
		<tr>
			<td className="manage-column column-cb check-column">
				<input type="checkbox" />
			</td>
			<th scope="col" className="manage-column column-username column-primary">Username</th>
			<th scope="col" className="manage-column column-name column-primary">Name</th>
			<th scope="col" className="manage-column column-email column-primary">Email</th>
			<th scope="col" className="manage-column column-role column-primary">Role</th>
		</tr>
	);

	if ( 'header' === type ) {
		return (
			<thead>
				{content}
			</thead>
		)
	}
	return (
		<tfoot>
			{content}
		</tfoot>
	)
};

export default TableHeaderFooter;
