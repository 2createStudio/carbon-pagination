<?php
/**
 * @group item
 * @group item_page
 */
class CarbonPaginationItemPageRenderTest extends WP_UnitTestCase {

	public function carbon_pagination_page_link($text) {
		return '<span class="bar">Foo</span>';
	}

	public function setUp() {
		$mock_methods = array( 'get_current_number_html', 'get_number_html', 'get_current_page' );
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML', array(), '', TRUE, TRUE, TRUE, $mock_methods);
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Page', null, $params);
		$this->item = $itemStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::render
	 */
	public function testWithCurrentPage() {
		$html = '<span class="current">Current Foo Bar</span>';
		$this->pagination->expects( $this->any() )
			->method( 'get_current_number_html' )
			->will( $this->returnValue( $html ) );

		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 5 ) );

		$this->item->set_page_number(4);
		$this->assertSame( $html, $this->item->render() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::render
	 */
	public function testWithOtherPage() {
		$html = '<span class="other">Other Foo Bar</span>';
		$this->pagination->expects( $this->any() )
			->method( 'get_number_html' )
			->will( $this->returnValue( $html ) );

		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 10 ) );

		$this->item->set_page_number(2);
		$this->assertSame( $html, $this->item->render() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::render
	 */
	public function testWithCustomHTML() {
		$html = '<span class="custom">Custom Foo Bar</span>';
		$this->item->set_html( $html );
		$this->assertSame( $html, $this->item->render() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::render
	 */
	public function testCurrentPageTextHTMLFilter() {
		add_filter('carbon_pagination_page_link', array($this, 'carbon_pagination_page_link'));

		$expected = $this->carbon_pagination_page_link('');
		$actual = $this->item->render();
		$this->assertSame( $expected, $actual );

		remove_filter('carbon_pagination_page_link', array($this, 'carbon_pagination_page_link'));
	}


	/**
	 * @covers Carbon_Pagination_Item_Page::render
	 */
	public function testCurrentPageTextHTMLFilterOverCustomHTML() {
		add_filter('carbon_pagination_page_link', array($this, 'carbon_pagination_page_link'));
		$html = '<span class="custom">Custom Foo Bar</span>';
		$this->item->set_html( $html );

		$expected = $this->carbon_pagination_page_link('');
		$actual = $this->item->render();
		$this->assertSame( $expected, $actual );

		remove_filter('carbon_pagination_page_link', array($this, 'carbon_pagination_page_link'));
	}

}