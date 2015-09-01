<?php
/**
 * @group pagination
 * @group pagination_post
 */
class CarbonPaginationPostGetPaginationPostsTest extends WP_UnitTestCase {
	
	public function carbon_pagination_post_pagination_query($q) {
		$q['order'] = 'ASC';
		return $q;
	}

	public function setUp() {
		parent::setUp();

		$paginationStub = $this->getMock( 'Carbon_Pagination_Post', null );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset($this->pagination);

		parent::tearDown();
	}

	/**
	 * @covers Carbon_Pagination_Post::get_pagination_posts
	 */
	public function testWithPosts() {
		$post_1 = $this->factory->post->create();
		$post_2 = $this->factory->post->create();
		$post_3 = $this->factory->post->create();

		$this->go_to('/?p=' . $post_2);

		$expected = array( $post_3, $post_2, $post_1 );
		$this->assertSame( $expected, $this->pagination->get_pagination_posts() );
	}

	/**
	 * @covers Carbon_Pagination_Post::get_pagination_posts
	 */
	public function testWithPages() {
		$page_args = array( 'post_type' => 'page' );
		$page_1 = $this->factory->post->create( $page_args );
		$page_2 = $this->factory->post->create( $page_args );
		$page_3 = $this->factory->post->create( $page_args );

		$this->go_to('/?page_id=' . $page_2);

		$expected = array( $page_3, $page_2, $page_1 );
		$this->assertSame( $expected, $this->pagination->get_pagination_posts() );
	}

	/**
	 * @covers Carbon_Pagination_Post::get_pagination_posts
	 */
	public function testPaginationQueryFilter() {
		add_filter('carbon_pagination_post_pagination_query', array($this, 'carbon_pagination_post_pagination_query'));

		$post_1 = $this->factory->post->create();
		$post_2 = $this->factory->post->create();
		$post_3 = $this->factory->post->create();

		$this->go_to('/?p=' . $post_2);

		$expected = array( $post_1, $post_2, $post_3 );
		$this->assertSame( $expected, $this->pagination->get_pagination_posts() );

		remove_filter('carbon_pagination_post_pagination_query', array($this, 'carbon_pagination_post_pagination_query'));
	}

}