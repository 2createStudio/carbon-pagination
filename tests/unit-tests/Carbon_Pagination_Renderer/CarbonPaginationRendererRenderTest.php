<?php

class CarbonPaginationRendererRenderTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array(), '', TRUE, TRUE, TRUE, array('get_wrapper_before', 'get_wrapper_after') );
		$this->pagination = $paginationStub;

		$params = array($this->pagination, false);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$collectionStub2 = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection2 = $collectionStub2;

		$params = array($this->collection);
		$rendererStub = $this->getMock('Carbon_Pagination_Renderer', null, $params);
		$this->renderer = $rendererStub;

		$item_params = array( $this->collection );

		$this->item1 = $this->getMock( 'Carbon_Pagination_Item', array( 'render' ), $item_params );
		$this->item1->expects( $this->any() )
			->method( 'render' )
			->will( $this->returnValue( '1' ) );

		$this->item2 = $this->getMock( 'Carbon_Pagination_Item', array( 'render' ), $item_params );
		$this->item2->expects( $this->any() )
			->method( 'render' )
			->will( $this->returnValue( '2' ) );

		$this->item3 = $this->getMock( 'Carbon_Pagination_Item', array( 'render' ), $item_params );
		$this->item3->expects( $this->any() )
			->method( 'render' )
			->will( $this->returnValue( '3' ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->collection2);
		unset($this->renderer);
		unset($this->item1);
		unset($this->item2);
		unset($this->item3);
	}

	public function testFlatItems() {
		$this->collection->add_items(array(
			$this->item1,
			$this->item2,
			$this->item3,
		));

		$this->assertSame( '123', $this->renderer->render( array(), false ) );
	}

	public function testFlatItemsParameter() {
		$items = array(
			$this->item1,
			$this->item2,
			$this->item3,
		);

		$this->assertSame( '123', $this->renderer->render( $items, false ) );
	}

	public function testNestedItems() {
		$this->item3->set_subitems_collection( $this->collection2 );
		$this->item3->get_subitems_collection()->add_items(array($this->item2, $this->item1));

		$this->collection->add_items(array(
			$this->item1,
			$this->item2,
			$this->item3,
		));

		$this->assertSame( '1221', $this->renderer->render( array(), false ) );
	}

	public function testNestedItemsParameter() {
		$this->item3->set_subitems_collection( $this->collection2 );
		$this->item3->get_subitems_collection()->add_items(array($this->item2, $this->item1));

		$items = array(
			$this->item1,
			$this->item2,
			$this->item3,
		);

		$this->assertSame( '1221', $this->renderer->render( $items, false ) );
	}

	public function testWithAllWrongItems() {
		$items = array(1, 2, 3);
		$this->assertSame( '', $this->renderer->render( $items, false ) );
	}

	public function testWithSomeWrongItems() {
		$items = array($this->item1, 1, $this->item3);
		$this->assertSame( '13', $this->renderer->render( $items, false ) );
	}

}