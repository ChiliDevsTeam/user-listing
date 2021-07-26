const Pagination = () => {
	return (
		<div className="tablenav-pages">
			<span className="displaying-num">115 items</span>
			<span className="pagination-links">
				<span className="tablenav-pages-navspan button disabled" aria-hidden="true">&laquo;</span>
				<span className="tablenav-pages-navspan button disabled" aria-hidden="true">&lsaquo;</span>
				<span className="screen-reader-text">Current Page</span>
				<span id="table-paging" className="paging-input">
					<span className="tablenav-paging-text">1 of <span className="total-pages">6</span></span>
				</span>
				<a className="next-page button" href="http://localhost/firstwork/wp-admin/users.php?paged=2">
					<span className="screen-reader-text">Next page</span>
					<span aria-hidden="true">&rsaquo;</span>
				</a>
				<a className="last-page button" href="http://localhost/firstwork/wp-admin/users.php?paged=6">
					<span className="screen-reader-text">Last page</span>
					<span aria-hidden="true">&raquo;</span>
				</a>
			</span>
		</div>
	)
}

export default Pagination;
