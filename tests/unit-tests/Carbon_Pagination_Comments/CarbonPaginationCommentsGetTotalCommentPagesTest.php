<?php
/**
 * @group pagination
 * @group pagination_comments
 */
class CarbonPaginationCommentsGetTotalCommentPagesTest extends WP_UnitTestCase {
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
	 * @covers Carbon_Pagination_Comments::get_total_comment_pages
	 */
	public function testMaxNumCommentPagesVar() {
		global $wp_query;
		$wp_query->max_num_comment_pages = 20;
		$this->assertSame( 20, $this->pagination->get_total_comment_pages() );
	}

	/**
	 * @covers Carbon_Pagination_Comments::get_total_comment_pages
	 */
	public function testMaxNumCommentPagesFloat() {
		global $wp_query;
		$wp_query->max_num_comment_pages = 6.1;
		$this->assertSame( 6, $this->pagination->get_total_comment_pages() );
	}

	/**
	 * @covers Carbon_Pagination_Comments::get_total_comment_pages
	 */
	public function testMaxNumCommentPagesNegative() {
		global $wp_query;
		$wp_query->max_num_comment_pages = -5;
		$this->assertSame( 1, $this->pagination->get_total_comment_pages() );
	}

	/**
	 * @covers Carbon_Pagination_Comments::get_total_comment_pages
	 */
	public function testGetCommentPagesCount() {
		global $wp_query;
		unset( $wp_query->max_num_comment_pages );
		$comments = array_map( 'get_comment', $this->comment_ids );
		$wp_query->comments = $comments;

		update_option('page_comments', 1);
		update_option('comments_per_page', 1);

		$this->assertSame( 10, $this->pagination->get_total_comment_pages() );

		update_option('page_comments', 0);
		update_option('comments_per_page', 0);
	}

}