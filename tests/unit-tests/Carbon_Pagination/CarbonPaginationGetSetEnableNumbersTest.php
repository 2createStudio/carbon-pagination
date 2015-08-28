<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetEnableNumbersTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_enable_numbers
	 * @covers Carbon_Pagination::set_enable_numbers
	 */
	public function testNonBool() {
		$this->pagination->set_enable_numbers( 0 );
		$this->assertSame( false, $this->pagination->get_enable_numbers() );

		$this->pagination->set_enable_numbers( "" );
		$this->assertSame( false, $this->pagination->get_enable_numbers() );

		$this->pagination->set_enable_numbers( 1 );
		$this->assertSame( true, $this->pagination->get_enable_numbers() );

		$this->pagination->set_enable_numbers( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_numbers() );
	}

}