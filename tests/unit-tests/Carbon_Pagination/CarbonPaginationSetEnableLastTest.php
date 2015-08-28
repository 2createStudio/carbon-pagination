<?php
/**
 * @group pagination
 */
class CarbonPaginationSetEnableLastTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::set_enable_last
	 */
	public function testNonBool() {
		$this->pagination->set_enable_last( 0 );
		$this->assertSame( false, $this->pagination->get_enable_last() );

		$this->pagination->set_enable_last( "" );
		$this->assertSame( false, $this->pagination->get_enable_last() );

		$this->pagination->set_enable_last( 1 );
		$this->assertSame( true, $this->pagination->get_enable_last() );

		$this->pagination->set_enable_last( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_last() );
	}

}