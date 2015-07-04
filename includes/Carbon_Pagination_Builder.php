<?php
/**
 * The Carbon Pagination main class.
 * Contains and manages all of the pagination settings and handles rendering.
 * Abstract, can be extended by all specific pagination types.
 *
 * @abstract
 * @uses Carbon_Pagination
 */
abstract class Carbon_Pagination_Builder extends Carbon_Pagination {

	/**
	 * Build and render the pagination.
	 *
	 * @access public
	 *
	 * @param string $echo Whether to display (true) or return (false) the HTML.
	 * @return string|null If $echo is false, the pagination HTML, NULL otherwise.
	 */
	public function render($echo = true) {
		$output = '';

		// Page X of Y
		$output .= $this->build_current_page_text();

		// first page link
		$output .= $this->build_first_page_link();

		// previous page link
		$output .= $this->build_prev_page_link();

		// page number links & limiters - 1, 2, 3, ... 10, 20, 30
		$output .= $this->build_page_links();

		// next page link
		$output .= $this->build_next_page_link();

		// last page link
		$output .= $this->build_last_page_link();

		// wrap the output in the pagination wrappers
		if ($output) {
			$output = $this->get_wrapper_before() . $output . $this->get_wrapper_after();
		}

		if (!$echo) {
			return $output;
		}

		echo $output;
	}

	/**
	 * Build the current page text.
	 * Applies the `carbon_pagination_current_page_text` filter on the output.
	 *
	 * @access public
	 *
	 * @return string $link The current page text HTML.
	 */
	public function build_current_page_text() {
		// bail if this feature is disabled
		if ( !$this->get_enable_current_page_text() ) {
			return '';
		}

		// get various pagination variables that we need
		$html = $this->get_current_page_html();
		$pages = $this->get_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);

		// parse tokens
		$tokens = array(
			'CURRENT_PAGE' => $current_page_idx + 1,
			'TOTAL_PAGES' => $this->get_total_pages(),
		);
		$html = $this->parse_tokens($html, $tokens);

		// allow the current page text HTML to be filtered
		$html = apply_filters('carbon_pagination_current_page_text', $html, $this);

		return $html;
	}

	/**
	 * Build the previous page link.
	 * Applies the `carbon_pagination_prev_page_link` filter on the output.
	 *
	 * @access public
	 *
	 * @return string $link The previous page link HTML.
	 */
	public function build_prev_page_link() {
		$link = '';

		// bail if this feature is disabled
		if ( !$this->get_enable_prev() ) {
			return $link;
		}

		// get various pagination variables that we need
		$pages = $this->get_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);
		$first_page = 0;

		// bail if there is no previous page
		if ($current_page_idx <= $first_page) {
			return $link;
		}

		// build the previous page link HTML
		$link = $this->build_page_link( $current_page_idx - 1, $this->get_prev_html() );

		// allow the previous page link HTML to be filtered
		$link = apply_filters('carbon_pagination_prev_page_link', $link, $this);

		return $link;
	}

	/**
	 * Build the next page link.
	 * Applies the `carbon_pagination_next_page_link` filter on the output.
	 *
	 * @access public
	 *
	 * @return string $link The next page link HTML.
	 */
	public function build_next_page_link() {
		$link = '';

		// bail if this feature is disabled
		if ( !$this->get_enable_next() ) {
			return $link;
		}

		// get various pagination variables that we need
		$pages = $this->get_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);
		$total_pages = $this->get_total_pages();

		// bail if there is no next page
		if ($current_page_idx >= $total_pages - 1) {
			return $link;
		}

		// build the next page link HTML
		$link = $this->build_page_link( $current_page_idx + 1, $this->get_next_html() );

		// allow the next page link HTML to be filtered
		$link = apply_filters('carbon_pagination_next_page_link', $link, $this);

		return $link;
	}

	/**
	 * Build the first page link.
	 * Applies the `carbon_pagination_first_page_link` filter on the output.
	 *
	 * @access public
	 *
	 * @return string $link The first page link HTML.
	 */
	public function build_first_page_link() {
		$link = '';

		// bail if this feature is disabled
		if ( !$this->get_enable_first() ) {
			return $link;
		}

		// get various pagination variables that we need
		$pages = $this->get_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);
		$first_page = 0;

		// bail if we are already on the first page
		if ($current_page_idx <= $first_page) {
			return $link;
		}

		// build the first page link HTML
		$link = $this->build_page_link( $first_page, $this->get_first_html() );

		// allow the first page link HTML to be filtered
		$link = apply_filters('carbon_pagination_first_page_link', $link, $this);

		return $link;
	}

	/**
	 * Build the last page link.
	 * Applies the `carbon_pagination_last_page_link` filter on the output.
	 *
	 * @access public
	 *
	 * @return string $link The last page link HTML.
	 */
	public function build_last_page_link() {
		$link = '';

		// bail if this feature is disabled
		if ( !$this->get_enable_last() ) {
			return $link;
		}

		// get various pagination variables that we need
		$pages = $this->get_pages();
		$total_pages = $this->get_total_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);

		// bail if we are already on the last page
		if ($current_page_idx >= $total_pages - 1) {
			return $link;
		}

		// build the last page link HTML
		$link = $this->build_page_link( $total_pages - 1, $this->get_last_html() );

		// allow the last page link HTML to be filtered
		$link = apply_filters('carbon_pagination_last_page_link', $link, $this);

		return $link;
	}

	/**
	 * Build the page number links.
	 * Loops through the pages themselves, allowing them to be IDs or anything else.
	 * Applies the `carbon_pagination_page_number_link` filter on each link.
	 *
	 * @access public
	 *
	 * @return string $output The page number links HTML.
	 */
	public function build_page_links() {
		// bail if this feature is disabled
		if ( !$this->get_enable_numbers() ) {
			return;
		}

		// get various pagination variables that we need
		$output = '';
		$pages = $this->get_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);
		$total_pages = $this->get_total_pages();
		$number_limit = $this->get_number_limit();
		$large_page_number_limit = $this->get_large_page_number_limit();
		$large_page_number_interval = $this->get_large_page_number_interval();
		$limiter = $this->build_limiter();

		// flags, indicating whether the limiters before & after have been displayed
		$displayed_limiter_before = false;
		$displayed_limiter_after = false;

		// loop through all pages
		for($i = 0; $i < $total_pages; $i++) {

			// if number limit is 0, we'll just display all pages
			if ( $number_limit ) {
				$distance = $current_page_idx - $i;

				// only display pages that are within the number limit
				if ( abs($distance) > $number_limit ) {

					// handle large page number links (10, 20, 30) before the current page
					if ($distance > 0 && !$displayed_limiter_before) {
						$output .= $limiter;
						$displayed_limiter_before = true;

						// display large page number links only if configured properly
						if ($large_page_number_limit && $large_page_number_interval) {
							$total_large_displayed = 0;

							// loop through all pages from the current to the last one
							for($j = $i; $j < $total_pages; $j++) {
								// if we've reached the current page, display the limiter
								if ($j == $current_page_idx - $number_limit) {
									$output .= $limiter;
									break;
								}

								// display a large page number link if needed
								if ( ($j % $large_page_number_interval) == $large_page_number_interval - 1 ) {
									// build large page link HTML
									$link = $this->build_page_link($j);

									// allow large page link HTML to be filtered
									$output .= apply_filters('carbon_pagination_large_page_number_link', $link, $this); 

									// increase large page number counter
									$total_large_displayed++;
								}

								// if we've reached the total number of allowed large pages
								// display a limiter and stop
								if ($total_large_displayed == $large_page_number_limit) {
									$output .= $limiter;
									break;
								}
							}
						}

					// handle large page number links (10, 20, 30) after the current page
					} elseif ($distance < 0 && !$displayed_limiter_after) {
						$output .= $limiter;
						$displayed_limiter_after = true;

						// display large page number links only if configured properly
						if ($large_page_number_limit && $large_page_number_interval) {
							$total_large_displayed = 0;
							
							// loop through all pages from the current to the last one
							for($j = $i; $j < $total_pages; $j++) {

								// display a large page number link if needed
								if ( ($j % $large_page_number_interval) == $large_page_number_interval - 1 ) {
									// build large page link HTML
									$link = $this->build_page_link($j);

									// allow large page link HTML to be filtered
									$output .= apply_filters('carbon_pagination_large_page_number_link', $link, $this); 

									// increase large page number counter
									$total_large_displayed++;
								}

								// if we've reached the total number of allowed large pages
								// display a limiter and stop
								if ($total_large_displayed == $large_page_number_limit && $j < $total_pages) {
									$output .= $limiter;
									break;
								}
							}
						}
					}

					// if there is a number limit specified
					// and this page exceeds it, skip it
					continue;
				}
			}

			// build the page number link HTML
			$link = $this->build_page_link($i);

			// allow the page number link HTML to be filtered
			$link = apply_filters('carbon_pagination_page_number_link', $link, $this);

			$output .= $link; 
		}

		// get rid of multiple neighbour limiters
		$output = str_replace($limiter . $limiter, $limiter, $output);

		// if there are any page number links, wrap them in the numbers wrappers
		if ($output) {
			$output = $this->get_numbers_wrapper_before() . $output . $this->get_numbers_wrapper_after();
		}

		return $output;
	}

	/**
	 * Build the limiter between page links.
	 * Applies the `carbon_pagination_limiter` filter on the output.
	 *
	 * @access public
	 *
	 * @return string $html The limiter HTML.
	 */
	public function build_limiter() {
		$html = $this->get_limiter_html();

		// bail if this feature is disabled
		if ( !$html ) {
			return;
		}

		// allow the limiter HTML to be filtered
		$html = apply_filters('carbon_pagination_limiter', $html, $this);

		return $html;
	}

	/**
	 * Build the link for a certain page number.
	 * Applies the `carbon_pagination_page_link` filter on the output.
	 *
	 * @access public
	 *
	 * @param int $page_number The page number.
	 * @param string $html Optional. The text of the link.
	 * @return string $link The link HTML.
	 */
	public function build_page_link($page_number = 0, $html = '') {
		// get all pagination pages
		$pages = $this->get_pages();

		// if there is no text/HTML for the link, use the default one
		if (!$html) {
			$html = $this->get_number_html();
		}

		// build the page link URL 
		$url = $this->get_page_url($page_number, $this->get_current_url());

		// parse tokens
		$tokens = array(
			'URL' => $url,
			'PAGE_NUMBER' => $page_number + 1,
		);
		$link = $this->parse_tokens($html, $tokens);

		// allow the page link HTML to be filtered
		$link = apply_filters('carbon_pagination_page_link', $link, $url, $page_number, $html, $this);

		return $link;
	}

	/**
	 * Parse all tokens within a string.
	 * 
	 * Tokens should be passed in the array in the following way:
	 * array( 'TOKENNAME' => 'tokenvalue' )
	 *
	 * Tokens should be used in the string in the following way:
	 * 'lorem {TOKENNAME} ipsum'
	 *
	 * @access protected
	 *
	 * @param string $string The unparsed string.
	 * @param array $tokens An array of tokens and their values.
	 * @return string $string The parsed string.
	 */
	protected function parse_tokens($string, $tokens = array()) {
		foreach ($tokens as $find => $replace) {
			$string = str_replace('{' . $find . '}', $replace, $string);
		}

		return $string;
	}

	/**
	 * Get the URL to a certain page.
	 *
	 * @access public
	 *
	 * @param int $page_number The page number.
	 * @param string $old_url Optional. The URL to add the page number to.
	 * @return string $url The URL to the page number.
	 */
	abstract public function get_page_url($page_number, $old_url = '');

}