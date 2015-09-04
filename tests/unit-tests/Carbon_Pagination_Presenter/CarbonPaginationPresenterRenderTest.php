<?php
/**
 * @group presenter
 */
class CarbonPaginationPresenterRenderTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination, false);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$rendererStub = $this->getMock('Carbon_Pagination_Renderer', null, $params);
		$this->renderer = $rendererStub;

		$presenter_args = array(
			$this->pagination,
		);
		$presenterStub = $this->getMockForAbstractClass( 'Carbon_Pagination_Presenter', $presenter_args );
		$this->presenter = $presenterStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->renderer);
		unset($this->presenter);
	}

	/**
	 * @covers Carbon_Pagination_Presenter::render
	 */
	public function testPresenterRender() {
		$expected = $this->renderer->render( array(), false );
		$actual = $this->presenter->render();
		$this->assertSame( $expected, $actual );
	}

}