<?php
/**
 * @group pagination
 */
class CarbonPaginationSetEnablePrevTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	public function testNonBool() {
		$this->pagination->set_enable_prev( 0 );
		$this->assertSame( false, $this->pagination->get_enable_prev() );

		$this->pagination->set_enable_prev( "" );
		$this->assertSame( false, $this->pagination->get_enable_prev() );

		$this->pagination->set_enable_prev( 1 );
		$this->assertSame( true, $this->pagination->get_enable_prev() );

		$this->pagination->set_enable_prev( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_prev() );
	}

}