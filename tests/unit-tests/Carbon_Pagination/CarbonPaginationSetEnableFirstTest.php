<?php
/**
 * @group pagination
 */
class CarbonPaginationSetEnableFirstTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

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