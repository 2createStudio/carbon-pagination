<?php
/**
 * @group pagination
 * @group pagination_custom
 */
class CarbonPaginationCustomGetSetQueryVarTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_Custom' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination_Custom::get_query_var
	 * @covers Carbon_Pagination_Custom::set_query_var
	 */
	public function testGetSetQueryVar() {
		$qv = 'foobar';
		$this->pagination->set_query_var( $qv );
		$this->assertSame( $qv, $this->pagination->get_query_var() );
	}

}