<?php
/**
 * @group item
 * @group item_direction_page
 * @group item_direction_page_forward
 */
class CarbonPaginationItemDirectionForwardPageGetDirectionDisabledTest extends WP_UnitTestCase {

	public function setUp() {
		$mock_methods = array( 'get_current_page', 'get_total_pages' );
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML', array(), '', TRUE, TRUE, TRUE, $mock_methods);
		$this->pagination = $paginationStub;
		$this->pagination->expects( $this->any() )
			->method( 'get_total_pages' )
			->will( $this->returnValue( 10 ) );

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$args = array(
			$this->collection
		);
		$this->item = $this->getMockForAbstractClass( 'Carbon_Pagination_Item_Direction_Forward_Page', $args );
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->item );
	}

	/**
	 * @covers Carbon_Pagination_Item_Direction_Forward_Page::get_direction_disabled
	 */
	public function testOnLastPage() {
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 10 ) );

		$this->assertTrue( $this->item->get_direction_disabled() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Direction_Forward_Page::get_direction_disabled
	 */
	public function testOnNonLastPage() {
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 5 ) );

		$this->assertFalse( $this->item->get_direction_disabled() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Direction_Forward_Page::get_direction_disabled
	 */
	public function testOnFirstPage() {
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 1 ) );

		$this->assertFalse( $this->item->get_direction_disabled() );
	}

}