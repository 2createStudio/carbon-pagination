<?php
/**
 * The Carbon Pagination HTML class.
 * Contains and manages the pagination HTML settings.
 * Abstract, can be extended by all specific pagination types.
 *
 * @uses Carbon_Pagination
 */
abstract class Carbon_Pagination_HTML extends Carbon_Pagination {

	/**
	 * @var string Wrapper - before.
	 */
	protected $wrapper_before = '<div class="paging">';

	/**
	 * @var string Wrapper - after.
	 */
	protected $wrapper_after = '</div>';

	/**
	 * @var string The wrapper before the page number links (1, 2, 3, etc).
	 */
	protected $numbers_wrapper_before = '<ul>';

	/**
	 * @var string The wrapper after the page number links (1, 2, 3, etc).
	 */
	protected $numbers_wrapper_after = '</ul>';

	/**
	 * @var string 
	 * 
	 * The HTML of the previous page link. You can use the following tokens:
	 * - {URL} - the link URL
	 */
	protected $prev_html = '<a href="{URL}" class="paging-prev"></a>';

	/**
	 * @var string 
	 * 
	 * The HTML of the next page link. You can use the following tokens:
	 * - {URL} - the link URL
	 */
	protected $next_html = '<a href="{URL}" class="paging-next"></a>';

	/**
	 * @var string 
	 * 
	 * The HTML of the first page link. You can use the following tokens:
	 * - {URL} - the link URL
	 */
	protected $first_html = '<a href="{URL}" class="paging-first"></a>';

	/**
	 * @var string 
	 * 
	 * The HTML of the last page link. You can use the following tokens:
	 * - {URL} - the link URL
	 */
	protected $last_html = '<a href="{URL}" class="paging-last"></a>';

	/**
	 * @var string 
	 * 
	 * The HTML of the page number link. You can use the following tokens:
	 * - {URL} - the link URL
	 * - {PAGE_NUMBER} - the particular page number
	 */
	protected $number_html = '<li><a href="{URL}">{PAGE_NUMBER}</a></li>';

	/**
	 * @var string
	 * 
	 * The HTML of the current page number link. You can use the following tokens:
	 * - {URL} - the link URL
	 * - {PAGE_NUMBER} - the particular page number
	 */
	protected $current_number_html = '<li class="current"><a href="{URL}">{PAGE_NUMBER}</a></li>';

	/**
	 * @var string The HTML of limiter between page number links.
	 */
	protected $limiter_html = '<li class="paging-spacer">...</li>';

	/**
	 * @var string
	 * 
	 * The current page text HTML. You can use the following tokens:
	 * - {CURRENT_PAGE} - the current page number
	 * - {TOTAL_PAGES} - the total number of pages
	 */
	protected $current_page_html = '<span class="paging-label">Page {CURRENT_PAGE} of {TOTAL_PAGES}</span>';

	/**
	 * Retrieve the pagination wrapper - before.
	 * 
	 * @return string $wrapper_before The pagination wrapper - before.
	 */
	public function get_wrapper_before() {
		return $this->wrapper_before;
	}

	/**
	 * Modify the pagination wrapper - before.
	 * 
	 * @param string $wrapper_before The new pagination wrapper - before.
	 */
	public function set_wrapper_before( $wrapper_before ) {
		$this->wrapper_before = $wrapper_before;
	}

	/**
	 * Retrieve the pagination wrapper - after.
	 * 
	 * @return string $wrapper_after The pagination wrapper - after.
	 */
	public function get_wrapper_after() {
		return $this->wrapper_after;
	}

	/**
	 * Modify the pagination wrapper - after.
	 * 
	 * @param string $wrapper_after The new pagination wrapper - after.
	 */
	public function set_wrapper_after( $wrapper_after ) {
		$this->wrapper_after = $wrapper_after;
	}

	/**
	 * Retrieve the pagination numbers wrapper - before.
	 * 
	 * @return string $numbers_wrapper_before The pagination numbers wrapper - before.
	 */
	public function get_numbers_wrapper_before() {
		return $this->numbers_wrapper_before;
	}

	/**
	 * Modify the pagination numbers wrapper - before.
	 * 
	 * @param string $numbers_wrapper_before The new pagination numbers wrapper - before.
	 */
	public function set_numbers_wrapper_before( $numbers_wrapper_before ) {
		$this->numbers_wrapper_before = $numbers_wrapper_before;
	}

	/**
	 * Retrieve the pagination numbers wrapper - after.
	 * 
	 * @return string $numbers_wrapper_after The pagination numbers wrapper - after.
	 */
	public function get_numbers_wrapper_after() {
		return $this->numbers_wrapper_after;
	}

	/**
	 * Modify the pagination numbers wrapper - after.
	 * 
	 * @param string $numbers_wrapper_after The new pagination numbers wrapper - after.
	 */
	public function set_numbers_wrapper_after( $numbers_wrapper_after ) {
		$this->numbers_wrapper_after = $numbers_wrapper_after;
	}

	/**
	 * Retrieve the previous page link HTML.
	 * 
	 * @return string $prev_html The previous page link HTML.
	 */
	public function get_prev_html() {
		return $this->prev_html;
	}

	/**
	 * Modify the previous page link HTML.
	 * 
	 * @param string $prev_html The new previous page link HTML.
	 */
	public function set_prev_html( $prev_html ) {
		$this->prev_html = $prev_html;
	}

	/**
	 * Retrieve the next page link HTML.
	 * 
	 * @return string $next_html The next page link HTML.
	 */
	public function get_next_html() {
		return $this->next_html;
	}

	/**
	 * Modify the next page link HTML.
	 * 
	 * @param string $next_html The new next page link HTML.
	 */
	public function set_next_html( $next_html ) {
		$this->next_html = $next_html;
	}

	/**
	 * Retrieve the first page link HTML.
	 * 
	 * @return string $first_html The first page link HTML.
	 */
	public function get_first_html() {
		return $this->first_html;
	}

	/**
	 * Modify the first page link HTML.
	 * 
	 * @param string $first_html The new first page link HTML.
	 */
	public function set_first_html( $first_html ) {
		$this->first_html = $first_html;
	}

	/**
	 * Retrieve the last page link HTML.
	 * 
	 * @return string $last_html The last page link HTML.
	 */
	public function get_last_html() {
		return $this->last_html;
	}

	/**
	 * Modify the last page link HTML.
	 * 
	 * @param string $last_html The new last page link HTML.
	 */
	public function set_last_html( $last_html ) {
		$this->last_html = $last_html;
	}

	/**
	 * Retrieve the HTML of a page number link.
	 * 
	 * @return string $number_html The HTML of a page number link.
	 */
	public function get_number_html() {
		return $this->number_html;
	}

	/**
	 * Modify the HTML of a page number link.
	 * 
	 * @param string $number_html The new HTML of a page number link.
	 */
	public function set_number_html( $number_html ) {
		$this->number_html = $number_html;
	}

	/**
	 * Retrieve the HTML of the current page number link.
	 * 
	 * @return string $current_number_html The HTML of the current page number link.
	 */
	public function get_current_number_html() {
		return $this->current_number_html;
	}

	/**
	 * Modify the HTML of the current page number link.
	 * 
	 * @param string $current_number_html The new HTML of the current page number link.
	 */
	public function set_current_number_html( $current_number_html ) {
		$this->current_number_html = $current_number_html;
	}

	/**
	 * Retrieve the HTML of a limiter.
	 * 
	 * @return string $limiter_html The HTML of a limiter.
	 */
	public function get_limiter_html() {
		return $this->limiter_html;
	}

	/**
	 * Modify the HTML of a limiter.
	 * 
	 * @param string $limiter_html The new HTML of a limiter.
	 */
	public function set_limiter_html( $limiter_html ) {
		$this->limiter_html = $limiter_html;
	}

	/**
	 * Retrieve the HTML of the current page text.
	 * 
	 * @return string $current_page_html The HTML of the current page text.
	 */
	public function get_current_page_html() {
		return $this->current_page_html;
	}

	/**
	 * Modify the HTML of the current page text.
	 * 
	 * @param string $current_page_html The new HTML of the current page text.
	 */
	public function set_current_page_html( $current_page_html ) {
		$this->current_page_html = $current_page_html;
	}

	/**
	 * Render the pagination.
	 * 
	 * @param bool $echo Whether to display or return the output. True will display, false will return.
	 */
	public function render( $echo = true ) {
		$presenter = new Carbon_Pagination_Presenter( $this );
		$output = $presenter->render();

		if ( ! $echo ) {
			return $output;
		}
		
		echo wp_kses( $output, wp_kses_allowed_html( 'post' ) );
	}

}