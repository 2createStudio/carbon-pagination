<?php
/**
 * @group item
 * @group item_limiter
 */
class CarbonPaginationItemLimiterRenderTest extends WP_UnitTestCase {

	public function carbon_pagination_limiter($text) {
		return '<span class="bar">Foo</span>';
	}

	public function setUp() {
		$mock_methods = array( 'get_limiter_html' );
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML', array(), '', TRUE, TRUE, TRUE, $mock_methods);
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Limiter', null, $params);
		$this->item = $itemStub;

		$this->html = '<span class="foo">Bar</span>';
		$this->pagination->expects( $this->any() )
			->method( 'get_limiter_html' )
			->will( $this->returnValue( $this->html ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
	}

	/**
	 * @covers Carbon_Pagination_Item_Limiter::render
	 */
	public function testCurrentPageTextHTML() {
		$this->assertSame( $this->html, $this->item->render() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Limiter::render
	 */
	public function testCurrentPageTextHTMLFilter() {
		add_filter('carbon_pagination_limiter', array($this, 'carbon_pagination_limiter'));

		$expected = $this->carbon_pagination_limiter('');
		$actual = $this->item->render();
		$this->assertSame( $expected, $actual );

		remove_filter('carbon_pagination_limiter', array($this, 'carbon_pagination_limiter'));
	}


}