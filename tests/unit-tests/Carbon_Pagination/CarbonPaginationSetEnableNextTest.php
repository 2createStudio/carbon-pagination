<?php
/**
 * @group pagination
 */
class CarbonPaginationSetEnableNextTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::set_enable_next
	 */
	public function testNonBool() {
		$this->pagination->set_enable_next( 0 );
		$this->assertSame( false, $this->pagination->get_enable_next() );

		$this->pagination->set_enable_next( "" );
		$this->assertSame( false, $this->pagination->get_enable_next() );

		$this->pagination->set_enable_next( 1 );
		$this->assertSame( true, $this->pagination->get_enable_next() );

		$this->pagination->set_enable_next( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_next() );
	}

}