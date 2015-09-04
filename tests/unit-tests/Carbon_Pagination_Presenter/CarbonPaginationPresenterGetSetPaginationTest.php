<?php
/**
 * @group presenter
 */
class CarbonPaginationPresenterGetSetPaginationTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$paginationStub2 = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination2 = $paginationStub2;

		$params = array($this->pagination);
		$presenterStub = $this->getMock('Carbon_Pagination_Presenter', null, $params);
		$this->presenter = $presenterStub;
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->pagination2 );
		unset( $this->presenter );
	}

	/**
	 * @covers Carbon_Pagination_Presenter::get_pagination
	 * @covers Carbon_Pagination_Presenter::set_pagination
	 */
	public function testGetSetPagination() {
		$this->presenter->set_pagination( $this->pagination2 );
		$this->assertSame( $this->pagination2, $this->presenter->get_pagination() );
	}

}