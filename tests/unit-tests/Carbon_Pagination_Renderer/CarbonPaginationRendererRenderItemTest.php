<?php
/**
 * @group renderer
 */
class CarbonPaginationRendererRenderItemTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$rendererStub = $this->getMock('Carbon_Pagination_Renderer', null, $params);
		$this->renderer = $rendererStub;

		$itemParams = array($this->collection);
		$itemStub = $this->getMockForAbstractClass( 'Carbon_Pagination_Item', $itemParams, '', TRUE, TRUE, TRUE, array('get_tokens', 'render') );
		$this->item = $itemStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->renderer);
		unset($this->item);
	}

	public function carbon_pagination_render_item_html( $html, $item ) {
		return '<strong class="bar">foo</strong>';
	}

	/**
	 * @covers Carbon_Pagination_Renderer::render_item
	 */
	public function testTokenParsing() {
		$tokens = array(
			'FOO' => 'foo bar',
			'BAR' => 'bar foo',
		);
		$html = '<span class="{FOO}">{BAR}</span>';

		$this->item->expects( $this->any() )
			->method('get_tokens')
			->will( $this->returnValue( $tokens ) );

		$this->item->expects( $this->any() )
			->method('render')
			->will( $this->returnValue( $html ) );

		$expected = '<span class="foo bar">bar foo</span>';
		$actual = $this->renderer->render_item( $this->item );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::render_item
	 */
	public function testCarbonPaginationRenderItemHtmlFilter() {
		$this->item->expects( $this->any() )
			->method('get_tokens')
			->will( $this->returnValue( array() ) );

		add_filter( 'carbon_pagination_render_item_html', array( $this, 'carbon_pagination_render_item_html' ), 10, 2 );

		$actual = $this->renderer->render_item( $this->item );
		$expected = $this->carbon_pagination_render_item_html( '', $this->item );
		$this->assertSame( $expected, $actual );

		remove_filter( 'carbon_pagination_render_item_html', array( $this, 'carbon_pagination_render_item_html' ), 10 );
	}

}