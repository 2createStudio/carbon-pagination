<?php

class CarbonPaginationGetCurrentPageIndex extends WP_UnitTestCase {

	public function testWithIncrementalPageNumbers() {
		$args = array(
			'total_pages' => 10,
			'current_page' => 3,
		);
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array($args) );

		$this->assertSame( 2, $paginationStub->get_current_page_index() );
	}

	public function testWithIncrementalPageNumbersPagesSetting() {
		$args = array(
			'pages' => range(1, 10),
			'current_page' => 3,
		);
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array($args) );

		$this->assertSame( 2, $paginationStub->get_current_page_index() );
	}

	public function testWithNonIncrementalPageNumbers() {
		$args = array(
			'pages' => array(30, 41, 52, 63),
			'current_page' => 3,
		);
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array($args) );

		$this->assertSame( 2, $paginationStub->get_current_page_index() );
	}
}