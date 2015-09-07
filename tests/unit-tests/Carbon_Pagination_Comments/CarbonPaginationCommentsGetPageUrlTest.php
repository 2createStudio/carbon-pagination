<?php
/**
 * @group pagination
 * @group pagination_comments
 */
class CarbonPaginationCommentsGetPageUrlTest extends WP_UnitTestCase {
	public function setUp() {
		parent::setUp();

		$this->post_id = $this->factory->post->create();
		$this->comment_ids = $this->factory->comment->create_post_comments( $this->post_id, 10 );

		global $wp_query;
		$wp_query = new WP_Query( array( 'p' => $this->post_id, 'comments_per_page' => 1, 'feed' =>'comments-' ) );

		$paginationStub = $this->getMock( 'Carbon_Pagination_Comments', null );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->post_id);
		unset($this->comment_ids);

		wp_reset_postdata();

		parent::tearDown();
	}

	/**
	 * @covers Carbon_Pagination_Comments::get_page_url
	 */
	public function testGetPageUrlDefault() {
		$expected = get_comments_pagenum_link( 5 );
		$actual = $this->pagination->get_page_url( 4 );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Comments::get_page_url
	 */
	public function testGetPageUrlWithOldUrl() {
		$expected = get_comments_pagenum_link( 4 );
		$actual = $this->pagination->get_page_url( 3, 'http://example.org/test/' );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Comments::get_page_url
	 */
	public function testGetPageUrlFirstPage() {
		$expected = get_comments_pagenum_link( 1 );
		$actual = $this->pagination->get_page_url( 0 );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Comments::get_page_url
	 */
	public function testGetPageUrlLargeUnexistingPage() {
		$expected = get_comments_pagenum_link( 21 );
		$actual = $this->pagination->get_page_url( 20 );
		$this->assertSame( $expected, $actual );
	}
}