import { HashRouter as Router, Switch, Route, Link } from 'react-router-dom';
import { __ } from '@wordpress/i18n';

import UserLists from './pages/UserLists';
import SingleUser from './pages/SingleUser';

const App = () => {
	return (
		<Router>
			<div className="wrap">
				<Switch>
					<Route key='/' path='/' exact>
						<UserLists />
					</Route>
				</Switch>
			</div>
		</Router>
	);
}

export default App;
