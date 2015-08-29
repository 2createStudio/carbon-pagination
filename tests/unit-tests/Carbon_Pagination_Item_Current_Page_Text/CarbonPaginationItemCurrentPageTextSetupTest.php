<?php
/**
 * @group item
 * @group item_current_page_text
 */
class CarbonPaginationItemCurrentPageTextSetupTest extends WP_UnitTestCase {

	public function setUp() {
		$mock_methods = array( 'get_current_page', 'get_total_pages' );
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination', array(), '', TRUE, TRUE, TRUE, $mock_methods);
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Current_Page_Text', null, $params);
		$this->item = $itemStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
	}

	/**
	 * @covers Carbon_Pagination_Item_Current_Page_Text::setup
	 */
	public function testAllTokensExistence() {
		$this->item->setup();
		$this->assertArrayHasKey( 'CURRENT_PAGE', $this->item->get_tokens() );
		$this->assertArrayHasKey( 'TOTAL_PAGES', $this->item->get_tokens() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Current_Page_Text::setup
	 */
	public function testAllTokenValues() {
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 5 ) );

		$this->pagination->expects( $this->any() )
			->method( 'get_total_pages' )
			->will( $this->returnValue( 10 ) );

		$this->item->setup();
		$tokens = $this->item->get_tokens();
		
		$this->assertSame( 5, $tokens['CURRENT_PAGE'] );
		$this->assertSame( 10, $tokens['TOTAL_PAGES'] );
	}

}