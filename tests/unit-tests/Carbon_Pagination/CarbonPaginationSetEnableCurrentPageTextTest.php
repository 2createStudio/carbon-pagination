<?php

class CarbonPaginationSetEnableCurrentPageTextTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	public function testNonBool() {
		$this->pagination->set_enable_current_page_text( 0 );
		$this->assertSame( false, $this->pagination->get_enable_current_page_text() );

		$this->pagination->set_enable_current_page_text( "" );
		$this->assertSame( false, $this->pagination->get_enable_current_page_text() );

		$this->pagination->set_enable_current_page_text( 1 );
		$this->assertSame( true, $this->pagination->get_enable_current_page_text() );

		$this->pagination->set_enable_current_page_text( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_current_page_text() );
	}

}