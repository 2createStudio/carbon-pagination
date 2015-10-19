<?php
/**
 * @group pagination
 * @group pagination_post
 */
class CarbonPaginationPostGetPostTitle extends WP_UnitTestCase {

	/**
	 * @covers Carbon_Pagination_Post::get_post_title
	 */
	public function testPostPaginationGetPostTitle() {
		$post_1 = $this->factory->post->create( array( 'post_title' => 'Foo Bar Title' ) );
		$this->go_to('/?p=' . $post_1);
		
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_Post');

		$params = array($paginationStub);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);

		$params = array($collectionStub, false);
		$item_page = $this->getMock('Carbon_Pagination_Item_Page', null, $params);

		$collectionStub->set_items( array(
			$item_page,
		) );

		$this->assertSame( 'Foo Bar Title', $paginationStub->get_post_title( $item_page ) );
	}

}