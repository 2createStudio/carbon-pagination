<?php
/**
 * @group renderer
 */
class CarbonPaginationRendererPrepareItemsTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$rendererStub = $this->getMock('Carbon_Pagination_Renderer', null, $params);
		$this->renderer = $rendererStub;

		$item_params = array( $this->collection );
		$this->item1 = $this->getMock( 'Carbon_Pagination_Item', array( 'render' ), $item_params );
		$this->item1->expects( $this->any() )
			->method( 'render' )
			->will( $this->returnValue( '1' ) );

		$this->item2 = $this->getMock( 'Carbon_Pagination_Item', array( 'render' ), $item_params );
		$this->item2->expects( $this->any() )
			->method( 'render' )
			->will( $this->returnValue( '2' ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->renderer);
		unset($this->item1);
		unset($this->item2);
	}

	/**
	 * @covers Carbon_Pagination_Renderer::prepare_items
	 */
	public function testGetItemsFromCollectionIfEmpty() {
		$items = array( $this->item1, $this->item2 );
		$this->collection->set_items( $items );

		$expected = $this->collection->get_items();
		$actual = $this->renderer->prepare_items();

		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::prepare_items
	 */
	public function testWithCorrectItems() {
		$items = array( $this->item2, $this->item1 );
		$result = $this->renderer->prepare_items( $items );

		$this->assertSame( $items, $result );
	}

}