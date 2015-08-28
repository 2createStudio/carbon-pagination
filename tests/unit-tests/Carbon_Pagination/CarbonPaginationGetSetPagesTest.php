<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetPagesTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_pages
	 * @covers Carbon_Pagination::set_pages
	 * @covers Carbon_Pagination::get_total_pages
	 */
	public function testNumericKeyArray() {
		$this->pagination->set_pages( array(
			5 => 10,
			6 => 20
		) );

		$this->assertSame( array(10, 20), $this->pagination->get_pages() );
		$this->assertSame( 2, $this->pagination->get_total_pages() );
	}

	/**
	 * @covers Carbon_Pagination::get_pages
	 * @covers Carbon_Pagination::set_pages
	 * @covers Carbon_Pagination::get_total_pages
	 */
	public function testAssociativeArray() {
		$this->pagination->set_pages( array(
			'foo' => 10,
			'bar' => 20
		) );

		$this->assertSame( array(10, 20), $this->pagination->get_pages() );
		$this->assertSame( 2, $this->pagination->get_total_pages() );
	}

	/**
	 * @covers Carbon_Pagination::get_pages
	 * @covers Carbon_Pagination::set_pages
	 * @covers Carbon_Pagination::get_total_pages
	 */
	public function testNonArray() {
		$this->pagination->set_pages( 5 );
		
		$this->assertSame( array(5), $this->pagination->get_pages() );
		$this->assertSame( 1, $this->pagination->get_total_pages() );
	}

}