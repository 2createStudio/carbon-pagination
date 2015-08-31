<?php
/**
 * @group item
 * @group item_html
 */
class CarbonPaginationItemHtmlRenderTest extends WP_UnitTestCase {

	protected $test_html = '<span class="foo">Bar</span>';

	public function carbon_pagination_html($text) {
		return '<span class="bar">Foo</span>';
	}

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination');
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$itemStub = $this->getMock( 'Carbon_Pagination_Item_HTML', array( 'get_html' ), $params );
		$this->item = $itemStub;

		$this->item->expects( $this->any() )
			->method( 'get_html' )
			->will( $this->returnValue( $this->test_html ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
	}

	/**
	 * @covers Carbon_Pagination_Item_HTML::render
	 */
	public function testHtmlRender() {
		$this->assertSame( $this->test_html, $this->item->render() );
	}

	/**
	 * @covers Carbon_Pagination_Item_HTML::render
	 */
	public function testHtmlRenderFilter() {
		add_filter('carbon_pagination_html', array($this, 'carbon_pagination_html'));

		$expected = $this->carbon_pagination_html('');
		$actual = $this->item->render();
		$this->assertSame( $expected, $actual );

		remove_filter('carbon_pagination_html', array($this, 'carbon_pagination_html'));
	}


}