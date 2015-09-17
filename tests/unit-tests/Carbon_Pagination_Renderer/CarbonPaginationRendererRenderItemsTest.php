<?php
/**
 * @group renderer
 */
class CarbonPaginationRendererRenderItemsTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->pagination, false);
		$subitemsCollectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->subitems_collection1 = $subitemsCollectionStub;

		$subitemsCollectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->subitems_collection2 = $subitemsCollectionStub;

		$params = array($this->collection);
		$rendererStub = $this->getMock('Carbon_Pagination_Renderer', null, $params);
		$this->renderer = $rendererStub;

		$itemParams = array($this->collection);
		$itemStub = $this->getMockForAbstractClass( 'Carbon_Pagination_Item', $itemParams, '', TRUE, TRUE, TRUE, array('render', 'get_subitems_collection') );
		$this->item1 = $itemStub;
		$this->item1->expects( $this->any() )
			->method('render')
			->will( $this->returnValue( '123' ) );

		$itemStub = $this->getMockForAbstractClass( 'Carbon_Pagination_Item', $itemParams, '', TRUE, TRUE, TRUE, array('render', 'get_subitems_collection') );
		$this->item2 = $itemStub;
		$this->item2->expects( $this->any() )
			->method('render')
			->will( $this->returnValue( '456' ) );

		$itemStub = $this->getMockForAbstractClass( 'Carbon_Pagination_Item', $itemParams, '', TRUE, TRUE, TRUE, array('render', 'get_subitems_collection') );
		$this->item3 = $itemStub;
		$this->item3->expects( $this->any() )
			->method('render')
			->will( $this->returnValue( '789' ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->subitems_collection1);
		unset($this->subitems_collection2);
		unset($this->renderer);
		unset($this->item1);
		unset($this->item2);
		unset($this->item3);
	}

}