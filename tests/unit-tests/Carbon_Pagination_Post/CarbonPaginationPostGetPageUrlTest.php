<?php
/**
 * @group pagination
 * @group pagination_post
 */
class CarbonPaginationPostGetPageUrlTest extends WP_UnitTestCase {

	/**
	 * @covers Carbon_Pagination_Post::get_page_url
	 */
	public function testGetUrlForPost() {
		$post_id = $this->factory->post->create();
		$this->go_to('/?p=' . $post_id);
		$pagination = $this->getMock( 'Carbon_Pagination_Post', null );

		$expected = get_permalink( $post_id );
		$this->assertSame( $expected, $pagination->get_page_url( 0 ) );
		$this->assertSame( $expected, $pagination->get_page_url( 0, '/foo/bar' ) );
	}

	/**
	 * @covers Carbon_Pagination_Post::get_page_url
	 */
	public function testGetUrlForPage() {
		$page_id = $this->factory->post->create( array(
			'post_type' => 'page'
		) );
		$this->go_to('/?page_id=' . $page_id);
		$pagination = $this->getMock( 'Carbon_Pagination_Post', null );

		$expected = get_permalink( $page_id );
		$this->assertSame( $expected, $pagination->get_page_url( 0 ) );
		$this->assertSame( $expected, $pagination->get_page_url( 0, '/foo/bar' ) );
	}
	
}