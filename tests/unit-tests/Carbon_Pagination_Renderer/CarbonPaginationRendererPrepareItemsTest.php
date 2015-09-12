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

	/**
	 * @covers Carbon_Pagination_Renderer::prepare_items
	 */
	public function testWithIncorrectItems() {
		$items = array( 123, $this->item2, 'FooBar', $this->item1, new StdClass, array() );
		$expected = array( $this->item2, $this->item1 );
		$actual = $this->renderer->prepare_items( $items );

		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::prepare_items
	 */
	public function testWithLibraryClasses() {
		// mocks of classes that are treated correct items
		$itemParams = array( $this->collection );
		$item = $this->getMock('Carbon_Pagination_Item', null, $itemParams);
		$itemCurrentPageText = $this->getMock('Carbon_Pagination_Item_Current_Page_Text', null, $itemParams);
		$itemDirectionBackwardPage = $this->getMockForAbstractClass('Carbon_Pagination_Item_Direction_Backward_Page', $itemParams);
		$itemDirectionForwardPage = $this->getMockForAbstractClass('Carbon_Pagination_Item_Direction_Forward_Page', $itemParams);
		$itemDirection = $this->getMockForAbstractClass('Carbon_Pagination_Item_Direction_Page', $itemParams);
		$itemFirstPage = $this->getMock('Carbon_Pagination_Item_First_Page', null, $itemParams);
		$itemHTML = $this->getMock('Carbon_Pagination_Item_HTML', null, $itemParams);
		$itemLastPage = $this->getMock('Carbon_Pagination_Item_Last_Page', null, $itemParams);
		$itemLimiter = $this->getMock('Carbon_Pagination_Item_Limiter', null, $itemParams);
		$itemNextPage = $this->getMock('Carbon_Pagination_Item_Next_Page', null, $itemParams);
		$itemNumberLinks = $this->getMock('Carbon_Pagination_Item_Number_Links', null, $itemParams);
		$itemPage = $this->getMock('Carbon_Pagination_Item_Page', null, $itemParams);
		$itemPreviousPage = $this->getMock('Carbon_Pagination_Item_Previous_Page', null, $itemParams);

		// mocks of classes that are not treated as correct items
		$collection = $this->collection;
		$presenter = $this->getMock('Carbon_Pagination_Presenter', null, array( $this->pagination ));
		$renderer = $this->renderer;
		$utilities = $this->getMock('Carbon_Pagination_Utilities');
		$pagination = $this->getMockForAbstractClass('Carbon_Pagination');
		$pagination_custom = $this->getMock('Carbon_Pagination_Custom');
		$pagination_html = $this->pagination;

		// all mocks
		$items = array(
			$item,
			$itemCurrentPageText,
			$itemDirectionBackwardPage,
			$itemDirectionForwardPage,
			$itemDirection,
			$itemFirstPage,
			$itemHTML,
			$itemLastPage,
			$itemLimiter,
			$itemNextPage,
			$itemNumberLinks,
			$itemPage,
			$itemPreviousPage,
			$collection,
			$presenter,
			$renderer,
			$utilities,
			$pagination,
			$pagination_custom,
			$pagination_html,
		);

		// expected mocks after the prepare_items() call
		$expected = array(
			$item,
			$itemCurrentPageText,
			$itemDirectionBackwardPage,
			$itemDirectionForwardPage,
			$itemDirection,
			$itemFirstPage,
			$itemHTML,
			$itemLastPage,
			$itemLimiter,
			$itemNextPage,
			$itemNumberLinks,
			$itemPage,
			$itemPreviousPage,
		);
		$actual = $this->renderer->prepare_items( $items );

		$this->assertSame( $expected, $actual );
	}

}