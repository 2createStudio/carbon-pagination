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
	
}