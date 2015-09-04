<?php
/**
 * @group presenter
 */
class CarbonPaginationPresenterDisplayTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset($this->pagination);
	}

	/**
	 * @covers Carbon_Pagination_Presenter::display
	 */
	public function testDisplayUnexistingPaginationType() {
		$this->assertWPError( Carbon_Pagination_Presenter::display('foo') );
	}

	/**
	 * @covers Carbon_Pagination_Presenter::display
	 */
	public function testDisplayWithEcho() {
		$this->assertNull( Carbon_Pagination_Presenter::display( 'custom', array() ) );
		$this->assertNull( Carbon_Pagination_Presenter::display( 'custom', array(), true ) );
	}

	/**
	 * @covers Carbon_Pagination_Presenter::display
	 */
	public function testDisplayWithoutEcho() {
		$this->assertSame( '', Carbon_Pagination_Presenter::display( 'custom', array(), false ) );
	}

}