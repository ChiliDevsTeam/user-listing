import { render } from '@wordpress/element';
import App from './App';

window.addEventListener( 'load', (event) => {
	render( <App />, document.getElementById( 'wp-user-listing' ) );
} );
