<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetCollectionTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_collection
	 * @covers Carbon_Pagination::set_collection
	 */
	public function testGetSetCollection() {
		$html = 'FooBar';
		$this->pagination->set_collection( $html );
		$this->assertSame( $html, $this->pagination->get_collection() );
	}

}