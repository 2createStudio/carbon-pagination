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

		$item_params = array( $this->collection );
		$this->item1 = $this->getMock( 'Carbon_Pagination_Item', null, $item_params );
		$this->item2 = $this->getMock( 'Carbon_Pagination_Item', null, $item_params );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->renderer);
		unset($this->presenter);
		unset($this->item1);
		unset($this->item2);
	}

	/**
	 * @covers Carbon_Pagination_Presenter::render
	 */
	public function testPresenterRenderEmpty() {
		$expected = $this->renderer->render( array(), false );
		$actual = $this->presenter->render();
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Presenter::render
	 */
	public function testPresenterRenderNonEmpty() {
		$this->collection->expects( $this->any() )
			->method( 'get_items' )
			->will( $this->returnValue( array( $this->item1, $this->item2 ) ) );

		$this->item1->expects( $this->any() )
			->method( 'get_html' )
			->will( $this->returnValue( array( 'Foo' ) ) );

		$this->item2->expects( $this->any() )
			->method( 'get_html' )
			->will( $this->returnValue( array( 'Bar' ) ) );

		$expected = $this->renderer->render( array(), false );
		$actual = $this->presenter->render();
		$this->assertSame( $expected, $actual );
	}

}