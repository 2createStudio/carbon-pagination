<?php
/**
 * @group renderer
 */
class CarbonPaginationRendererGetSetCollectionTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$collectionStub2 = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection2 = $collectionStub2;

		$params = array($this->collection);
		$rendererStub = $this->getMock('Carbon_Pagination_Renderer', null, $params);
		$this->renderer = $rendererStub;
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->collection2 );
		unset( $this->renderer );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::get_collection
	 * @covers Carbon_Pagination_Renderer::set_collection
	 */
	public function testGetSetCollection() {
		$this->renderer->set_collection( $this->collection2 );
		$this->assertSame( $this->collection2, $this->renderer->get_collection() );
	}

}