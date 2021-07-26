import { HashRouter as Router, Switch, Route, Link } from 'react-router-dom';
import { __ } from '@wordpress/i18n';
// import { lazy } from '@wordpress/element';
// import LazyComponent from 'jsPath/components/LazyComponent';

// const UserLists = lazy( () => import( './pages/UserLists' ) );
// const SingleUser = lazy( () => import( './pages/SingleUser' ) );
import UserLists from './pages/UserLists';
import SingleUser from './pages/SingleUser';

const App = () => {
	return (
		<Router>
			<div className="wrap">
				<Link to="/">All</Link>
				<Link to="/test">Single</Link>
				<Switch>
					<Route key='/' path='/' exact>
						<UserLists />
					</Route>
					<Route key='/test' path='/test'>
						<SingleUser />
					</Route>
				</Switch>
			</div>
		</Router>
	);
}

export default App;
