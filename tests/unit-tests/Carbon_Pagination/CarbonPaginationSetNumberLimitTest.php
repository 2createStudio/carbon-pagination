<?php

class CarbonPaginationSetNumberLimitTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	public function testNegative() {
		$this->pagination->set_number_limit( -1 );
		$this->assertSame( -1, $this->pagination->get_number_limit() );
	}

	public function testZero() {
		$this->pagination->set_number_limit( 0 );
		$this->assertSame( 0, $this->pagination->get_number_limit() );
	}

	public function testNonNumeric() {
		$this->pagination->set_number_limit( 'foo' );
		$this->assertSame( 0, $this->pagination->get_number_limit() );

		$this->pagination->set_number_limit( '' );
		$this->assertSame( 0, $this->pagination->get_number_limit() );
	}

	public function testStringNumber() {
		$this->pagination->set_number_limit( '10' );
		$this->assertSame( 10, $this->pagination->get_number_limit() );
	}

}