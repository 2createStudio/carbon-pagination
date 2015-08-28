<?php
/**
 * @group pagination
 */
class CarbonPaginationSetLargePageNumberInterval extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::set_large_page_number_interval
	 */
	public function testNegative() {
		$this->pagination->set_large_page_number_interval( -5 );
		$this->assertSame( 5, $this->pagination->get_large_page_number_interval() );
	}

	/**
	 * @covers Carbon_Pagination::set_large_page_number_interval
	 */
	public function testZero() {
		$this->pagination->set_large_page_number_interval( 0 );
		$this->assertSame( 0, $this->pagination->get_large_page_number_interval() );
	}

	/**
	 * @covers Carbon_Pagination::set_large_page_number_interval
	 */
	public function testNonNumeric() {
		$this->pagination->set_large_page_number_interval( 'foo' );
		$this->assertSame( 0, $this->pagination->get_large_page_number_interval() );

		$this->pagination->set_large_page_number_interval( '' );
		$this->assertSame( 0, $this->pagination->get_large_page_number_interval() );
	}

	/**
	 * @covers Carbon_Pagination::set_large_page_number_interval
	 */
	public function testStringNumber() {
		$this->pagination->set_large_page_number_interval( '15' );
		$this->assertSame( 15, $this->pagination->get_large_page_number_interval() );
	}

}