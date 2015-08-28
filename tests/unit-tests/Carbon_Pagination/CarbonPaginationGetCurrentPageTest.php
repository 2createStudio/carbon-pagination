<?php
/**
 * @group pagination
 */
class CarbonPaginationGetCurrentPageTest extends WP_UnitTestCase {

	/**
	 * @covers Carbon_Pagination::get_current_page
	 */
	public function testWithIncrementalPageNumbers() {
		$args = array(
			'total_pages' => 10,
			'current_page' => 3,
		);
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array($args) );

		$this->assertSame( 3, $paginationStub->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination::get_current_page
	 */
	public function testWithIncrementalPageNumbersPagesSetting() {
		$args = array(
			'pages' => range(1, 10),
			'current_page' => 3,
		);
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array($args) );

		$this->assertSame( 3, $paginationStub->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination::get_current_page
	 */
	public function testWithNonIncrementalPageNumbers() {
		$args = array(
			'pages' => array(30, 41, 52, 63),
			'current_page' => 3,
		);
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array($args) );

		$this->assertSame( 3, $paginationStub->get_current_page() );
	}
}