<?php
/**
 * @group item
 * @group item_number_links
 */
class CarbonPaginationItemNumberLinksGenerateRegularNumberPagesTest extends WP_UnitTestCase {

	public function setUp() {
		// mock pagination
		$mock_methods = array( 'get_number_limit', 'get_total_pages', 'get_current_page' );
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML', array(), '', TRUE, TRUE, TRUE, $mock_methods);
		$this->pagination = $paginationStub;

		// mock collection
		$params = array($this->pagination, false);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		// mock item
		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Number_Links', null, $params, '', false);
		$this->item = $itemStub;
		$this->item->set_collection($this->collection);

		// setup item's subitems collection manually
		$params = array( $this->pagination, false );
		$this->subitems_collection = $this->getMock('Carbon_Pagination_Collection', null, $params );
		$this->item->set_subitems_collection( $this->subitems_collection );

		// mock total number of pages is always the same
		$this->pagination->expects( $this->any() )
			->method( 'get_total_pages' )
			->will( $this->returnValue( 10 ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
		unset($this->subitems_collection);
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_regular_number_pages
	 */
	public function testGenerateRegularNumberPagesWithNumber0LimitAtBeginning() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 0 ) );

		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 1 ) );

		$this->item->generate_regular_number_pages();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( 1, count($items) );
		$this->assertSame( 0, $items[0]->get_page_number() );
	}

}