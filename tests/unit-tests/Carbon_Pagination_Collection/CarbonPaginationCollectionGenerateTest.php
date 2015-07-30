<?php

class CarbonPaginationCollectionGenerateTest extends WP_UnitTestCase {

	private $mock_methods = array(
		'get_enable_current_page_text',
		'get_enable_first',
		'get_enable_prev',
		'get_enable_numbers',
		'get_enable_next',
		'get_enable_last',
	);

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination', array(), '', TRUE, TRUE, TRUE, $this->mock_methods);
		$this->pagination = $paginationStub;

		$params = array($this->pagination, false);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
	}

	public function testWithNothingEnabled() {
		foreach ($this->mock_methods as $method) {
			$this->pagination->expects( $this->any() )
				->method( $method )
				->will( $this->returnValue( false ) );
		}

		$this->collection->generate();

		$this->assertSame( array(), $this->collection->get_items() );
	}

	public function testWithOneItemEnabled() {
		$mock_true_methods = array(
			'get_enable_prev'
		);

		foreach ($this->mock_methods as $method) {
			if ( in_array( $method, $mock_true_methods ) ) {
				continue;
			}

			$this->pagination->expects( $this->any() )
				->method( $method )
				->will( $this->returnValue( false ) );
		}

		foreach ($mock_true_methods as $method) {
			$this->pagination->expects( $this->any() )
				->method( $method )
				->will( $this->returnValue( true ) );
		}

		$this->collection->generate();
		$items = $this->collection->get_items();

		$this->assertSame( 3, count( $items ) );

		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[0] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Previous_Page', $items[1] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[2] );
	}

	public function testWithOneItemDisabled() {
		$mock_false_methods = array(
			'get_enable_current_page_text'
		);

		foreach ($this->mock_methods as $method) {
			if ( in_array( $method, $mock_false_methods ) ) {
				continue;
			}

			$this->pagination->expects( $this->any() )
				->method( $method )
				->will( $this->returnValue( true ) );
		}

		foreach ($mock_false_methods as $method) {
			$this->pagination->expects( $this->any() )
				->method( $method )
				->will( $this->returnValue( false ) );
		}

		$this->collection->generate();
		$items = $this->collection->get_items();

		$this->assertSame( 7, count( $items ) );

		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[0] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_First_Page', $items[1] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Previous_Page', $items[2] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Number_Links', $items[3] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Next_Page', $items[4] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Last_Page', $items[5] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[6] );
	}

	public function testWithAllItemsEnabled() {
		foreach ($this->mock_methods as $method) {
			$this->pagination->expects( $this->any() )
				->method( $method )
				->will( $this->returnValue( true ) );
		}

		$this->collection->generate();
		$items = $this->collection->get_items();

		$this->assertSame( 8, count( $items ) );

		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[0] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Current_Page_Text', $items[1] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_First_Page', $items[2] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Previous_Page', $items[3] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Number_Links', $items[4] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Next_Page', $items[5] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Last_Page', $items[6] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[7] );
	}

}