/**
 * WordPress dependencies
 */
import { Spinner } from '@wordpress/components';

const PageSpinner = ( { text, children } ) => {
    return (
        <div className="wpul-spinner">
            <Spinner />
            { text && ( <span className="spinner-description">{ text }...</span> ) }
            { children }
        </div>
    );
};

export default PageSpinner;
