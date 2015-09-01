<?php
/**
 * @group pagination
 * @group pagination_posts
 * @group constructors
 */
class CarbonPaginationPostsConstructTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		update_option('posts_per_page', 1);

		for($i = 1; $i <= 5; $i++) {
			$this->factory->post->create();
		}

		$this->go_to('/?paged=2');

		$paginationStub = $this->getMock( 'Carbon_Pagination_Posts', null );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset($this->pagination);

		parent::tearDown();
	}

	/**
	 * @covers Carbon_Pagination_Posts::__construct
	 */
	public function testDefaultArgsTotalPages() {
		$this->assertSame( 5, $this->pagination->get_total_pages() );
	}

	/**
	 * @covers Carbon_Pagination_Posts::__construct
	 */
	public function testDefaultArgsCurrentPage() {
		$this->assertSame( 2, $this->pagination->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination_Posts::__construct
	 */
	public function testDefaultArgsPrevHtml() {
		$expected = '<a href="{URL}" class="paging-prev">« Previous Entries</a>';
		$this->assertSame( $expected, $this->pagination->get_prev_html() );
	}

	/**
	 * @covers Carbon_Pagination_Posts::__construct
	 */
	public function testDefaultArgsNextHtml() {
		$expected = '<a href="{URL}" class="paging-next">Next Entries »</a>';
		$this->assertSame( $expected, $this->pagination->get_next_html() );
	}

	/**
	 * @covers Carbon_Pagination_Posts::__construct
	 */
	public function testCustomUnexistingArgs() {
		$args = array( 
			array( 
				'enable_numbers' => true
			)
		);
		$pagination = $this->getMock( 'Carbon_Pagination_Posts', null, $args );

		$this->assertSame( true, $pagination->get_enable_numbers() );
	}

	/**
	 * @covers Carbon_Pagination_Posts::__construct
	 */
	public function testCustomExistingArgs() {
		$args = array( 
			array( 
				'total_pages' => 20
			)
		);
		$pagination = $this->getMock( 'Carbon_Pagination_Posts', null, $args );

		$this->assertSame( 20, $pagination->get_total_pages() );
	}

}