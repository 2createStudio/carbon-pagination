<?php
/**
 * @group pagination
 * @group pagination_post
 * @group constructors
 */
class CarbonPaginationPostConstructTest extends WP_UnitTestCase {
	protected $post_ids = array();

	public function setUp() {
		parent::setUp();

		for($i = 1; $i <= 3; $i++) {
			array_unshift($this->post_ids, $this->factory->post->create());
		}

		$this->go_to('/?p=' . $this->post_ids[1]);

		$paginationStub = $this->getMock( 'Carbon_Pagination_Post', null );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->post_ids);

		parent::tearDown();
	}

	/**
	 * @covers Carbon_Pagination_Post::__construct
	 */
	public function testDefaultArgsPages() {
		$pages = $this->pagination->get_pagination_posts();

		$this->assertSame( $pages, $this->pagination->get_pages() );
	}

	/**
	 * @covers Carbon_Pagination_Post::__construct
	 */
	public function testDefaultArgsCurrentPage() {
		$pages = $this->pagination->get_pagination_posts();
		$current_page = array_search( get_the_ID(), $pages ) + 1;

		$this->assertSame( $current_page, $this->pagination->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination_Post::__construct
	 */
	public function testDefaultArgsPrevHtml() {
		$expected = '<a href="{URL}" class="paging-prev">« Previous Entry</a>';
		$this->assertSame( $expected, $this->pagination->get_prev_html() );
	}

	/**
	 * @covers Carbon_Pagination_Post::__construct
	 */
	public function testDefaultArgsNextHtml() {
		$expected = '<a href="{URL}" class="paging-next">Next Entry »</a>';
		$this->assertSame( $expected, $this->pagination->get_next_html() );
	}

	/**
	 * @covers Carbon_Pagination_Post::__construct
	 */
	public function testCustomUnexistingArgs() {
		$args = array( 
			array( 
				'enable_numbers' => true
			)
		);
		$pagination = $this->getMock( 'Carbon_Pagination_Post', null, $args );

		$this->assertSame( true, $pagination->get_enable_numbers() );
	}

	/**
	 * @covers Carbon_Pagination_Post::__construct
	 */
	public function testCustomExistingArgs() {
		$pages = array(1, 2, 3, 4, 5);
		$args = array( 
			array( 
				'pages' => $pages
			)
		);
		$pagination = $this->getMock( 'Carbon_Pagination_Post', null, $args );

		$this->assertSame( $pages, $pagination->get_pages() );
	}

}