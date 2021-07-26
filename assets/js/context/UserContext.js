import { useContext, createContext, useReducer } from 'react';
import userReducer from 'jsPath/stores/UserReducer';

const UserContext = createContext();

const initialState = {
	users: [],
	totalUsers: 0,
	totalPage: 0,
	usersError: false,
	usersLoading: false,
}

const UserProvider = ({ children }) => {
	const [ state, dispatch ] = useReducer( userReducer, initialState );

	return (
		<UserContext.Provider
		  value={ { ...state, dispatch } }
		>
		  {children}
		</UserContext.Provider>
	  )
}

// make sure use
export const useUserContext = () => {
	return useContext( UserContext )
}

export { UserContext, UserProvider }

