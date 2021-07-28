import { useUserContext } from 'jsPath/context/UserContext';

const TableBody = () => {
	const { users, usersError, usersLoading } = useUserContext();

	if ( usersLoading ) {
		return (
			<tbody>
				<tr>
					<td colSpan="5">
						Loading data....
					</td>
				</tr>
			</tbody>
		)
	}

	if ( usersError ) {
		return (
			<tbody>
				<tr>
					<td colSpan="5">
						{ usersError }
					</td>
				</tr>
			</tbody>
		)
	}

	if ( users ) {
		return (
			<tbody>
				{ users.map( ( user ) => {
					return (
						<tr id={ `user-${ user.id }` }>
							<th scope="row" className="check-column">
								<label className="screen-reader-text" htmlFor={ `user_${ user.id }` }>Select { user.username }</label>
								<input type="checkbox" name="users[]" id={ `user_${ user.id }` } className="author" value={ user.id } />
							</th>
							<td className="username column-username has-row-actions column-primary" data-colname="Username">
								<img alt={ user.full_name } src={ user.avatar.url } srcSet={ `${ user.avatar.url } 2x`} className='avatar avatar-32 photo avatar-default' height='32' width='32' loading='lazy'/>
								<strong><a href="#">{ user.username }</a></strong>
								<br />
								<div className="row-actions">
									<span className="edit">
										<a href="#">Edit</a> | &nbsp;
									</span>
									<span className="delete">
										<a className="submitdelete" href="#">Delete</a>
									</span>
								</div>
							</td>
							<td className="name column-name" data-colname="Name">{ user.full_name }</td>
							<td className="email column-email" data-colname="Email">
								<a href="mailto:{ user.email }">{ user.email }</a>
							</td>
							<td className="role column-role" data-colname="Role">
								{ Object.keys( user.roles ).map( (role) => { return user.roles[role] } ).join( ',' ) }
							</td>
						</tr>
					)
				} ) }
			</tbody>
		)
	}

}

export default TableBody;
