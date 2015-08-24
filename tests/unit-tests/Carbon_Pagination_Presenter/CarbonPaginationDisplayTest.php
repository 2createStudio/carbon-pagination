<?php
/**
 * @group presenter
 */
class CarbonPaginationPresenterDisplayTest extends WP_UnitTestCase {

	public function testDisplayUnexistingPaginationType() {
		$this->assertWPError( Carbon_Pagination_Presenter::display('foo') );
	}

}