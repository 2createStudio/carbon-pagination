<?php
/**
 * @group item
 * @group item_direction_page
 */
class CarbonPaginationItemDirectionPageInitTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$args = array(
			$this->collection
		);
		$methods = array( 'get_direction_disabled', 'get_collection' );
		$this->item = $this->getMockForAbstractClass( 'Carbon_Pagination_Item_Direction_Page', $args, '', FALSE, TRUE, TRUE, $methods );
		$this->item->expects( $this->any() )
			->method( 'get_collection' )
			->will( $this->returnValue( $this->collection ) );

	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->item );
	}

	/**
	 * @covers Carbon_Pagination_Item_Direction_Page::init
	 */
	public function testWithDirectionDisabled() {
		$this->item->expects( $this->any() )
			->method( 'get_direction_disabled' )
			->will( $this->returnValue( true ) );

		$this->item->init();

		$this->assertFalse( $this->item->get_subitems_collection() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Direction_Page::init
	 */
	public function testWithDirectionEnabled() {
		$this->item->expects( $this->any() )
			->method( 'get_direction_disabled' )
			->will( $this->returnValue( false ) );

		$this->item->init();

		$this->assertInstanceOf( 'Carbon_Pagination_Collection', $this->item->get_subitems_collection() );
		$this->assertSame( 1, count( $this->item->get_subitems_collection()->get_items() ) );
	}

}