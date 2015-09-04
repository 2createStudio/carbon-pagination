<?php
/**
 * @group presenter
 * @group constructors
 */
class CarbonPaginationPresenterConstructTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination_Presenter::__construct
	 */
	public function testIfPaginationProperlySet() {
		$params = array($this->pagination);
		$presenter = $this->getMock('Carbon_Pagination_Presenter', null, $params);
		$this->assertSame( $this->pagination, $presenter->get_pagination() );
	}

}