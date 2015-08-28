<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetEnableFirstTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_enable_first
	 * @covers Carbon_Pagination::set_enable_first
	 */
	public function testNonBool() {
		$this->pagination->set_enable_first( 0 );
		$this->assertSame( false, $this->pagination->get_enable_first() );

		$this->pagination->set_enable_first( "" );
		$this->assertSame( false, $this->pagination->get_enable_first() );

		$this->pagination->set_enable_first( 1 );
		$this->assertSame( true, $this->pagination->get_enable_first() );

		$this->pagination->set_enable_first( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_first() );
	}

}