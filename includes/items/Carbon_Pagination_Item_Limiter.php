<?php
/**
 * The Carbon Pagination limiter class.
 * Responsible for the limiter between page links.
 *
 * @uses Carbon_Pagination_Item
 */
class Carbon_Pagination_Item_Limiter extends Carbon_Pagination_Item {

	/**
	 * Render the item.
	 *
	 * @return string $html The HTML of the item.
	 */
	public function render() {
		$pagination = $this->get_collection()->get_pagination();

		$html = $pagination->get_limiter_html();
		$html = apply_filters( 'carbon_pagination_limiter', $html, $this );

		return $html;
	}

}