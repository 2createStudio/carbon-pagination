<?php
/**
 * @group pagination
 * @group pagination_comments
 * @group constructors
 */
class CarbonPaginationCommentsConstructTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		$this->comments_per_page = get_option( 'comments_per_page' );
		$this->page_comments = get_option( 'page_comments' );
		update_option( 'comments_per_page', 1 );
		update_option( 'page_comments', true );

		$this->post_id = $this->factory->post->create();
		$this->comment_ids = $this->factory->comment->create_post_comments( $this->post_id, 10 );

		global $wp_query;
		$wp_query = new WP_Query( array( 'p' => $this->post_id, 'comments_per_page' => 1, 'feed' =>'comments-', 'cpage' => 3 ) );

		$paginationStub = $this->getMock( 'Carbon_Pagination_Comments', null );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		wp_reset_postdata();

		update_option( 'comments_per_page', $this->comments_per_page );
		update_option( 'page_comments', $this->page_comments );

		unset($this->pagination);
		unset($this->post_id);
		unset($this->comment_ids);
		unset($this->comments_per_page);
		unset($this->page_comments);

		parent::tearDown();
	}

	/**
	 * @covers Carbon_Pagination_Comments::__construct
	 */
	public function testDefaultArgsTotalPages() {
		$total_pages = $this->pagination->get_total_comment_pages();

		$this->assertSame( $total_pages, $this->pagination->get_total_pages() );
	}

	/**
	 * @covers Carbon_Pagination_Comments::__construct
	 */
	public function testDefaultArgsCurrentPage() {
		$this->assertSame( 3, $this->pagination->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination_Comments::__construct
	 */
	public function testDefaultArgsPrevHtml() {
		$expected = '<a href="{URL}" class="paging-prev">« Older Comments</a>';
		$this->assertSame( $expected, $this->pagination->get_prev_html() );
	}

	/**
	 * @covers Carbon_Pagination_Comments::__construct
	 */
	public function testDefaultArgsNextHtml() {
		$expected = '<a href="{URL}" class="paging-next">Newer Comments »</a>';
		$this->assertSame( $expected, $this->pagination->get_next_html() );
	}

	/**
	 * @covers Carbon_Pagination_Comments::__construct
	 */
	public function testCustomUnexistingArgs() {
		$args = array( 
			array( 
				'enable_numbers' => true
			)
		);
		$pagination = $this->getMock( 'Carbon_Pagination_Comments', null, $args );

		$this->assertSame( true, $pagination->get_enable_numbers() );
	}

	/**
	 * @covers Carbon_Pagination_Comments::__construct
	 */
	public function testCustomExistingArgs() {
		$args = array( 
			array( 
				'total_pages' => 20
			)
		);
		$pagination = $this->getMock( 'Carbon_Pagination_Comments', null, $args );

		$this->assertSame( 20, $pagination->get_total_pages() );
	}

}