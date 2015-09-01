<?php
/**
 * @group item
 * @group item_page
 */
class CarbonPaginationItemPageSetupTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination', array(), '', TRUE, TRUE, TRUE, array());
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Page', array('get_page_number'), $params);
		$this->item = $itemStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::setup
	 */
	public function testAllTokensExistence() {
		$this->item->setup();
		$this->assertArrayHasKey( 'URL', $this->item->get_tokens() );
		$this->assertArrayHasKey( 'PAGE_NUMBER', $this->item->get_tokens() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::setup
	 */
	public function testAllTokenValues() {
		$page_number = 5;
		$url = $this->pagination->get_page_url( $page_number );

		$this->item->expects( $this->any() )
			->method( 'get_page_number' )
			->will( $this->returnValue( $page_number ) );

		$this->item->setup();
		$tokens = $this->item->get_tokens();
		
		$this->assertSame( $url, $tokens['URL'] );
		$this->assertSame( $page_number + 1, $tokens['PAGE_NUMBER'] );
	}

}