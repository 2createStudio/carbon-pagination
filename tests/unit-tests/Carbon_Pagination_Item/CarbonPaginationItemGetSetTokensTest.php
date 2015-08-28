<?php
/**
 * @group item
 * @group item_base
 */
class CarbonPaginationItemGetSetTokensTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$this->item = $this->getMock('Carbon_Pagination_Item', null, $params);
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->item );
	}

	/**
	 * @covers Carbon_Pagination_Item::get_tokens
	 * @covers Carbon_Pagination_Item::set_tokens
	 */
	public function testGetSetTokens() {
		$tokens = array(
			'FOO' => 'bar',
			'BAR' => 'foo',
		);
		$this->item->set_tokens( $tokens );
		$this->assertSame( $tokens, $this->item->get_tokens() );
	}

}