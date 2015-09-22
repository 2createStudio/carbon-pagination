<?php
/**
 * @group collection
 */
class CarbonPaginationCollectionGetItemPrototypesTest extends WP_UnitTestCase {

	public function customPrototypes() {
		return array(
			'foobar' => 'FooBar',
			'barfoo' => 'BarFoo',
		);
	}

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML');
		$this->pagination = $paginationStub;

		$params = array($this->pagination, false);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
	}

	/**
	 * @covers Carbon_Pagination_Collection::get_item_prototypes
	 */
	public function testDefaultItemPrototypes() {
		$expected = array(
			'get_enable_current_page_text' => 'Carbon_Pagination_Item_Current_Page_Text',
			'get_enable_first' => 'Carbon_Pagination_Item_First_Page',
			'get_enable_prev' => 'Carbon_Pagination_Item_Previous_Page',
			'get_enable_numbers' => 'Carbon_Pagination_Item_Number_Links',
			'get_enable_next' => 'Carbon_Pagination_Item_Next_Page',
			'get_enable_last' => 'Carbon_Pagination_Item_Last_Page',
		);
		$actual = $this->collection->get_item_prototypes();
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Collection::get_item_prototypes
	 */
	public function testCustomItemPrototypesFilter() {
		add_filter('carbon_pagination_default_collection_items', array($this, 'customPrototypes'));

		$this->assertSame( $this->customPrototypes(), $this->collection->get_item_prototypes() );

		remove_filter('carbon_pagination_default_collection_items', array($this, 'customPrototypes'));
	}

}