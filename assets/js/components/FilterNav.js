const FilterNav = () => {
	return (
		<div className="alignleft actions bulkactions">
			<label htmlFor="bulk-action-selector-top" className="screen-reader-text">Bulk action</label>

			<select name="action" id="bulk-action-selector-top">
				<option value="-1">-- Select --</option>
				<option value="delete">Delete</option>
			</select>

			<button className="button action">Apply</button>
		</div>
	)
}

export default FilterNav;
