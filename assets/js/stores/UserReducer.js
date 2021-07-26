const userReducer = ( state, action ) => {

	switch ( action.type ) {

		case 'FETCH_USERS_LOADING':
			return { ...state, usersLoading: true }
			break;

		case 'FETCH_USERS':
			return {
				...state,
				users: action.payload,
				usersError: false,
				usersLoading: false,
			}
			break;

		case 'FETCH_USERS_HEADER':
			return {
				...state,
				totalPage: Number( action.payload.totalPage ),
				totalUsers: Number( action.payload.totalUsers ),
			}
			break;

		case 'FETCH_USERS_ERRORS':
			return { ...state, usersError: action.payload, usersLoading: false }
			break;

	}
}

export default userReducer;
