<?php
/**
 * @group pagination
 */
class CarbonPaginationSetTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::set
	 */
	public function testBasicPropertySet() {
		$args = array(
			'total_pages' => 5,
			'current_page' => 2,
		);
		$this->pagination->set( $args );

		$this->assertSame( 5, $this->pagination->get_total_pages() );
		$this->assertSame( 2, $this->pagination->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination::set
	 */
	public function testPropertySetWithCast() {
		$args = array(
			'total_pages' => '5',
			'current_page' => '2',
		);
		$this->pagination->set( $args );

		$this->assertSame( 5, $this->pagination->get_total_pages() );
		$this->assertSame( 2, $this->pagination->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination::set
	 */
	public function testUnexistingProperties() {
		$this->pagination->set_total_pages(3);

		$args = array(
			'set_total_pages' => 10,
			'_total_pages' => 10,
			'' => 5,
		);
		$this->pagination->set( $args );

		$this->assertSame( 3, $this->pagination->get_total_pages() );
	}

}