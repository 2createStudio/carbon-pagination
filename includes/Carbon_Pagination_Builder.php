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
	 * Render the pagination.
	 *
	 * @access public
	 *
	 * @param string $echo Whether to display (true) or return (false) the HTML.
	 */
	public function render($echo = true) {
		$output = '';

		$output .= $this->build_current_page_text();

		$output .= $this->build_first_page_link();
		$output .= $this->build_prev_page_link();

		$output .= $this->build_page_links();

		$output .= $this->build_next_page_link();
		$output .= $this->build_last_page_link();

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
		if ( !$this->get_enable_current_page_text() ) {
			return '';
		}

		$html = $this->get_current_page_html();
		$pages = $this->get_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);

		$tokens = array(
			'CURRENT_PAGE' => $current_page_idx + 1,
			'TOTAL_PAGES' => $this->get_total_pages(),
		);
		$html = $this->parse_tokens($html, $tokens);

		return apply_filters('carbon_pagination_current_page_text', $html, $this);
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
		if ( !$this->get_enable_prev() ) {
			return $link;
		}

		$pages = $this->get_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);
		$first_page = 0;

		if ($current_page_idx <= $first_page) {
			return $link;
		}

		$link = $this->build_page_link( $current_page_idx - 1, $this->get_prev_html() );

		return apply_filters('carbon_pagination_prev_page_link', $link, $this);
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
		if ( !$this->get_enable_next() ) {
			return $link;
		}

		$pages = $this->get_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);
		$total_pages = $this->get_total_pages();

		if ($current_page_idx >= $total_pages - 1) {
			return $link;
		}

		$link = $this->build_page_link( $current_page_idx + 1, $this->get_next_html() );

		return apply_filters('carbon_pagination_next_page_link', $link, $this);
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
		if ( !$this->get_enable_first() ) {
			return $link;
		}

		$pages = $this->get_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);
		$first_page = 0;

		if ($current_page_idx <= $first_page) {
			return $link;
		}

		$link = $this->build_page_link( $first_page, $this->get_first_html() );

		return apply_filters('carbon_pagination_first_page_link', $link, $this);
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
		if ( !$this->get_enable_last() ) {
			return $link;
		}

		$pages = $this->get_pages();
		$total_pages = $this->get_total_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);

		if ($current_page_idx >= $total_pages - 1) {
			return $link;
		}

		$link = $this->build_page_link( $total_pages - 1, $this->get_last_html() );

		return apply_filters('carbon_pagination_last_page_link', $link, $this);
	}

	/**
	 * Build the page number links.
	 * Applies the `carbon_pagination_page_number_link` filter on each link.
	 *
	 * @access public
	 *
	 * @return string $output The page number links HTML.
	 */
	public function build_page_links() {
		if ( !$this->get_enable_numbers() ) {
			return;
		}

		$output = '';
		$pages = $this->get_pages();
		$current_page = $this->get_current_page();
		$current_page_idx = array_search($current_page, $pages);
		$total_pages = $this->get_total_pages();
		$number_limit = $this->get_number_limit();
		$large_page_number_limit = $this->get_large_page_number_limit();
		$large_page_number_interval = $this->get_large_page_number_interval();
		$limiter = $this->build_limiter();

		$displayed_limiter_before = false;
		$displayed_limiter_after = false;

		for($i = 0; $i < $total_pages; $i++) {
			if ( $number_limit ) {
				$distance = $current_page_idx - $i;

				if ( abs($distance) > $number_limit ) {
					if ($distance > 0 && !$displayed_limiter_before) {
						$output .= $limiter;
						$displayed_limiter_before = true;

						if ($large_page_number_limit && $large_page_number_interval) {
							$total_large_displayed = 0;

							for($j = $i; $j < $total_pages; $j++) {
								if ($j == $current_page_idx - $number_limit) {
									$output .= $limiter;
									break;
								}

								if ( ($j % $large_page_number_interval) == $large_page_number_interval - 1 ) {
									$link = $this->build_page_link($j);
									$output .= apply_filters('carbon_pagination_large_page_number_link', $link, $this); 
									$total_large_displayed++;
								}

								if ($total_large_displayed == $large_page_number_limit) {
									$output .= $limiter;
									break;
								}
							}
						}
					} elseif ($distance < 0 && !$displayed_limiter_after) {
						$output .= $limiter;
						$displayed_limiter_after = true;

						if ($large_page_number_limit && $large_page_number_interval) {
							$total_large_displayed = 0;
							
							for($j = $i; $j < $total_pages; $j++) {
								if ( ($j % $large_page_number_interval) == $large_page_number_interval - 1 ) {
									$link = $this->build_page_link($j);
									$output .= apply_filters('carbon_pagination_large_page_number_link', $link, $this); 
									$total_large_displayed++;
								}

								if ($total_large_displayed == $large_page_number_limit && $j < $total_pages) {
									$output .= $limiter;
									break;
								}
							}
						}
					}

					continue;
				}
			}

			$link = $this->build_page_link($i);
			$output .= apply_filters('carbon_pagination_page_number_link', $link, $this); 
		}

		$output = str_replace($limiter . $limiter, $limiter, $output);

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
		if ( !$html ) {
			return;
		}

		return apply_filters('carbon_pagination_limiter', $html, $this);
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
		$pages = $this->get_pages();

		if (!$html) {
			$html = $this->get_number_html();
		}

		$url = $this->get_page_url($page_number, $this->get_current_url());
		$tokens = array(
			'URL' => $url,
			'PAGE_NUMBER' => $page_number + 1,
		);
		$link = $this->parse_tokens($html, $tokens);

		return apply_filters('carbon_pagination_page_link', $link, $url, $page_number, $html, $this);
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