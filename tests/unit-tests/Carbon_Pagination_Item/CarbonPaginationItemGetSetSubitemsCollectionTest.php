<?php
/**
 * @group item
 * @group item_base
 */
class CarbonPaginationItemGetSetSubitemsCollectionTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$this->subitems_collection = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->subitems_collection2 = $this->getMock('Carbon_Pagination_Collection', null, $params);

		$params = array($this->subitems_collection);
		$this->item = $this->getMock('Carbon_Pagination_Item', null, $params);
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->subitems_collection );
		unset( $this->subitems_collection2 );
		unset( $this->item );
	}

	/**
	 * @covers Carbon_Pagination_Item::get_subitems_collection
	 * @covers Carbon_Pagination_Item::set_subitems_collection
	 */
	public function testGetSetSubitemsCollection() {
		$this->item->set_subitems_collection( $this->subitems_collection2 );
		$this->assertSame( $this->subitems_collection2, $this->item->get_subitems_collection() );
	}

}