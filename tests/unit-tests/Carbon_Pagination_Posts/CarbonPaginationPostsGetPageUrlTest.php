<?php
/**
 * @group pagination
 * @group pagination_posts
 */
class CarbonPaginationPostsGetPageUrlTest extends WP_UnitTestCase {

	public function setUp() {
		$args = array(
			array(
				'total_pages' => 10,
			)
		);
		$paginationStub = $this->getMock( 'Carbon_Pagination_Posts', null, $args );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset($this->pagination);
	}

	/**
	 * @covers Carbon_Pagination_Posts::get_page_url
	 */
	public function testGetPageUrlDefault() {
		$expected = home_url('/?paged=6');
		$actual = $this->pagination->get_page_url( 5 );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Posts::get_page_url
	 */
	public function testGetPageUrlWithOldUrl() {
		$expected = home_url('/?paged=3');
		$actual = $this->pagination->get_page_url( 2, '/foobar' );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Posts::get_page_url
	 */
	public function testGetPageUrlFirstPage() {
		$expected = home_url('/');
		$actual = $this->pagination->get_page_url( 0 );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Posts::get_page_url
	 */
	public function testGetPageUrlLargeUnexistingPage() {
		$expected = home_url('/');
		$actual = $this->pagination->get_page_url( 20 );
		$this->assertSame( $expected, $actual );
	}

}