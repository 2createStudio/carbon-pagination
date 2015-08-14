<?php
/**
 * @group pagination
 */
class CarbonPaginationDisplayTest extends WP_UnitTestCase {

	public function testRenderUnexistingPaginationType() {
		$this->assertWPError( Carbon_Pagination::display('foo') );
	}

}