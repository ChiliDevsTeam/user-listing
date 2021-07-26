/**
 * WordPress dependencies
 */
import { Suspense, Fragment } from '@wordpress/element';

/**
 * Internal dependencies
 */
import PageSpinner from './PageSpinner';

const LazyComponent = ( { children } ) => {
    let showSpinner = false;

    const suspenseLoader = (
        <Fragment>
            {
                showSpinner && <PageSpinner />
            }
        </Fragment>
    );

    setTimeout( () => showSpinner = true, 400 );

    return (
        <Suspense fallback={ suspenseLoader }>
            { children }
        </Suspense>
    );
};

export default LazyComponent;
