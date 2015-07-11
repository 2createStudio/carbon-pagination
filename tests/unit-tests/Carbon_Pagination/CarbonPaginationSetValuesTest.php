<?php

class CarbonPaginationSetValuesTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	public function testSetPagesNumericKeyArray() {
		$this->pagination->set_pages( array(
			5 => 10,
			6 => 20
		) );
		$this->assertSame( array(10, 20), $this->pagination->get_pages() );
	}

	public function testSetPagesAssociativeArray() {
		$this->pagination->set_pages( array(
			'foo' => 10,
			'bar' => 20
		) );
		$this->assertSame( array(10, 20), $this->pagination->get_pages() );
	}

	public function testSetPagesNonArray() {
		$this->pagination->set_pages( 5 );
		$this->assertSame( array(5), $this->pagination->get_pages() );
	}

	public function testSetCurrentPageNegative() {
		$this->pagination->set_current_page( -5 );
		$this->assertSame( 1, $this->pagination->get_current_page() );
	}

	public function testSetCurrentPageZero() {
		$this->pagination->set_current_page( 0 );
		$this->assertSame( 1, $this->pagination->get_current_page() );
	}

	public function testSetCurrentPageNonNumeric() {
		$this->pagination->set_current_page( 'foo' );
		$this->assertSame( 1, $this->pagination->get_current_page() );

		$this->pagination->set_current_page( '' );
		$this->assertSame( 1, $this->pagination->get_current_page() );
	}

	public function testSetCurrentPageStringNumber() {
		$this->pagination->set_total_pages( 20 );
		$this->pagination->set_current_page( '10' );
		$this->assertSame( 10, $this->pagination->get_current_page() );
	}

	public function testSetCurrentPageLargerThanTotal() {
		$this->pagination->set_total_pages( 10 );
		$this->pagination->set_current_page( 20 );
		$this->assertSame( 10, $this->pagination->get_current_page() );
	}

	public function testSetTotalPagesNegative() {
		$this->pagination->set_total_pages( -5 );
		$this->assertSame( 1, $this->pagination->get_total_pages() );
	}

	public function testSetTotalPagesZero() {
		$this->pagination->set_total_pages( 0 );
		$this->assertSame( 1, $this->pagination->get_total_pages() );
	}

	public function testSetTotalPagesNonNumeric() {
		$this->pagination->set_total_pages( 'foo' );
		$this->assertSame( 1, $this->pagination->get_total_pages() );

		$this->pagination->set_total_pages( '' );
		$this->assertSame( 1, $this->pagination->get_total_pages() );
	}

	public function testSetTotalPagesStringNumber() {
		$this->pagination->set_total_pages( '10' );
		$this->assertSame( 10, $this->pagination->get_total_pages() );
	}

	public function testSetEnablePrevNonBool() {
		$this->pagination->set_enable_prev( 0 );
		$this->assertSame( false, $this->pagination->get_enable_prev() );

		$this->pagination->set_enable_prev( "" );
		$this->assertSame( false, $this->pagination->get_enable_prev() );

		$this->pagination->set_enable_prev( 1 );
		$this->assertSame( true, $this->pagination->get_enable_prev() );

		$this->pagination->set_enable_prev( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_prev() );
	}

	public function testSetEnableNextNonBool() {
		$this->pagination->set_enable_next( 0 );
		$this->assertSame( false, $this->pagination->get_enable_next() );

		$this->pagination->set_enable_next( "" );
		$this->assertSame( false, $this->pagination->get_enable_next() );

		$this->pagination->set_enable_next( 1 );
		$this->assertSame( true, $this->pagination->get_enable_next() );

		$this->pagination->set_enable_next( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_next() );
	}

	public function testSetEnableFirstNonBool() {
		$this->pagination->set_enable_first( 0 );
		$this->assertSame( false, $this->pagination->get_enable_first() );

		$this->pagination->set_enable_first( "" );
		$this->assertSame( false, $this->pagination->get_enable_first() );

		$this->pagination->set_enable_first( 1 );
		$this->assertSame( true, $this->pagination->get_enable_first() );

		$this->pagination->set_enable_first( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_first() );
	}

	public function testSetEnableLastNonBool() {
		$this->pagination->set_enable_last( 0 );
		$this->assertSame( false, $this->pagination->get_enable_last() );

		$this->pagination->set_enable_last( "" );
		$this->assertSame( false, $this->pagination->get_enable_last() );

		$this->pagination->set_enable_last( 1 );
		$this->assertSame( true, $this->pagination->get_enable_last() );

		$this->pagination->set_enable_last( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_last() );
	}

	public function testSetEnableNumbersNonBool() {
		$this->pagination->set_enable_numbers( 0 );
		$this->assertSame( false, $this->pagination->get_enable_numbers() );

		$this->pagination->set_enable_numbers( "" );
		$this->assertSame( false, $this->pagination->get_enable_numbers() );

		$this->pagination->set_enable_numbers( 1 );
		$this->assertSame( true, $this->pagination->get_enable_numbers() );

		$this->pagination->set_enable_numbers( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_numbers() );
	}

	public function testSetEnableCurrentPageTextNonBool() {
		$this->pagination->set_enable_current_page_text( 0 );
		$this->assertSame( false, $this->pagination->get_enable_current_page_text() );

		$this->pagination->set_enable_current_page_text( "" );
		$this->assertSame( false, $this->pagination->get_enable_current_page_text() );

		$this->pagination->set_enable_current_page_text( 1 );
		$this->assertSame( true, $this->pagination->get_enable_current_page_text() );

		$this->pagination->set_enable_current_page_text( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_current_page_text() );
	}

	public function testSetNumberLimitNegative() {
		$this->pagination->set_number_limit( -5 );
		$this->assertSame( 5, $this->pagination->get_number_limit() );
	}

	public function testSetNumberLimitZero() {
		$this->pagination->set_number_limit( 0 );
		$this->assertSame( 0, $this->pagination->get_number_limit() );
	}

	public function testSetNumberLimitNonNumeric() {
		$this->pagination->set_number_limit( 'foo' );
		$this->assertSame( 0, $this->pagination->get_number_limit() );

		$this->pagination->set_number_limit( '' );
		$this->assertSame( 0, $this->pagination->get_number_limit() );
	}

	public function testSetNumberLimitStringNumber() {
		$this->pagination->set_number_limit( '10' );
		$this->assertSame( 10, $this->pagination->get_number_limit() );
	}

	public function testSetLargePageNumberLimitNegative() {
		$this->pagination->set_large_page_number_limit( -5 );
		$this->assertSame( 5, $this->pagination->get_large_page_number_limit() );
	}

	public function testSetLargePageNumberLimitZero() {
		$this->pagination->set_large_page_number_limit( 0 );
		$this->assertSame( 0, $this->pagination->get_large_page_number_limit() );
	}

	public function testSetLargePageNumberLimitNonNumeric() {
		$this->pagination->set_large_page_number_limit( 'foo' );
		$this->assertSame( 0, $this->pagination->get_large_page_number_limit() );

		$this->pagination->set_large_page_number_limit( '' );
		$this->assertSame( 0, $this->pagination->get_large_page_number_limit() );
	}

	public function testSetLargePageNumberLimitStringNumber() {
		$this->pagination->set_large_page_number_limit( '10' );
		$this->assertSame( 10, $this->pagination->get_large_page_number_limit() );
	}

	public function testSetLargePageNumberIntervalNegative() {
		$this->pagination->set_large_page_number_interval( -5 );
		$this->assertSame( 5, $this->pagination->get_large_page_number_interval() );
	}

	public function testSetLargePageNumberIntervalZero() {
		$this->pagination->set_large_page_number_interval( 0 );
		$this->assertSame( 0, $this->pagination->get_large_page_number_interval() );
	}

	public function testSetLargePageNumberIntervalNonNumeric() {
		$this->pagination->set_large_page_number_interval( 'foo' );
		$this->assertSame( 0, $this->pagination->get_large_page_number_interval() );

		$this->pagination->set_large_page_number_interval( '' );
		$this->assertSame( 0, $this->pagination->get_large_page_number_interval() );
	}

	public function testSetLargePageNumberIntervalStringNumber() {
		$this->pagination->set_large_page_number_interval( '15' );
		$this->assertSame( 15, $this->pagination->get_large_page_number_interval() );
	}

}