<?php
/**
 * @group pagination
 */
class CarbonPaginationSetEnableNumbersTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

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