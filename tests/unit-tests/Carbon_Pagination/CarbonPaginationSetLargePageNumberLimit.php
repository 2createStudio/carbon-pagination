<?php
/**
 * @group pagination
 */
class CarbonPaginationSetLargePageNumberLimit extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	public function testNegative() {
		$this->pagination->set_large_page_number_limit( -5 );
		$this->assertSame( 5, $this->pagination->get_large_page_number_limit() );
	}

	public function testZero() {
		$this->pagination->set_large_page_number_limit( 0 );
		$this->assertSame( 0, $this->pagination->get_large_page_number_limit() );
	}

	public function testNonNumeric() {
		$this->pagination->set_large_page_number_limit( 'foo' );
		$this->assertSame( 0, $this->pagination->get_large_page_number_limit() );

		$this->pagination->set_large_page_number_limit( '' );
		$this->assertSame( 0, $this->pagination->get_large_page_number_limit() );
	}

	public function testStringNumber() {
		$this->pagination->set_large_page_number_limit( '10' );
		$this->assertSame( 10, $this->pagination->get_large_page_number_limit() );
	}


}