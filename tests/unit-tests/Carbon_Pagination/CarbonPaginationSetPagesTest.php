<?php

class CarbonPaginationSetPagesTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	public function testNumericKeyArray() {
		$this->pagination->set_pages( array(
			5 => 10,
			6 => 20
		) );
		$this->assertSame( array(10, 20), $this->pagination->get_pages() );
	}

	public function testAssociativeArray() {
		$this->pagination->set_pages( array(
			'foo' => 10,
			'bar' => 20
		) );
		$this->assertSame( array(10, 20), $this->pagination->get_pages() );
	}

	public function testNonArray() {
		$this->pagination->set_pages( 5 );
		$this->assertSame( array(5), $this->pagination->get_pages() );
	}

}