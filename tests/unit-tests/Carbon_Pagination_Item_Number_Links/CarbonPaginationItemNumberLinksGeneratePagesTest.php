<?php
/**
 * @group item
 * @group item_number_links
 */
class CarbonPaginationItemNumberLinksGeneratePagesTest extends WP_UnitTestCase {

	public function setUp() {
		// mock pagination
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML');
		$this->pagination = $paginationStub;

		// mock collection
		$params = array($this->pagination, false);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		// mock item
		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Number_Links', null, $params, '', false);
		$this->item = $itemStub;
		$this->item->set_collection($this->collection);

		// setup item's subitems collection manually
		$params = array( $this->pagination, false );
		$this->subitems_collection = $this->getMock('Carbon_Pagination_Collection', null, $params );
		$this->item->set_subitems_collection( $this->subitems_collection );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
		unset($this->subitems_collection);
	}

}