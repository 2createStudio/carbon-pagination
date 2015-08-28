<?php
/**
 * @group pagination
 */
class CarbonPaginationSetCurrentPageTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;

		$paginationStub2 = $this->getMockForAbstractClass('Carbon_Pagination', array(), '', TRUE, TRUE, TRUE, array('get_total_pages'));
		$this->pagination2 = $paginationStub2;
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->pagination2 );
	}

	/**
	 * @covers Carbon_Pagination::set_current_page
	 */
	public function testNegative() {
		$this->pagination->set_current_page( -5 );
		$this->assertSame( 1, $this->pagination->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination::set_current_page
	 */
	public function testZero() {
		$this->pagination->set_current_page( 0 );
		$this->assertSame( 1, $this->pagination->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination::set_current_page
	 */
	public function testNonNumeric() {
		$this->pagination->set_current_page( 'foo' );
		$this->assertSame( 1, $this->pagination->get_current_page() );

		$this->pagination->set_current_page( '' );
		$this->assertSame( 1, $this->pagination->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination::set_current_page
	 */
	public function testStringNumber() {
		$this->pagination2->expects( $this->any() )
			->method( 'get_total_pages' )
			->will( $this->returnValue( 20 ) );

		$this->pagination2->set_current_page( '10' );
		$this->assertSame( 10, $this->pagination2->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination::set_current_page
	 */
	public function testLargerThanTotal() {
		$this->pagination2->expects( $this->any() )
			->method( 'get_total_pages' )
			->will( $this->returnValue( 10 ) );
		$this->pagination2->set_current_page( 20 );
		$this->assertSame( 10, $this->pagination2->get_current_page() );
	}

}