<?php
/**
 * @group pagination
 * @group pagination_post
 */
class CarbonPaginationPostAddTokensTest extends WP_UnitTestCase {

	/**
	 * @covers Carbon_Pagination_Post::add_tokens
	 */
	public function testPostPaginationAddTokens() {
		$post_1 = $this->factory->post->create();
		$post_2 = $this->factory->post->create();
		$post_3 = $this->factory->post->create();

		$this->go_to('/?p=' . $post_2);
		
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_Post');

		$params = array($paginationStub);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);

		$params = array($collectionStub, false);
		$item = $this->getMock('Carbon_Pagination_Item', null, $params);
		$item_page = $this->getMock('Carbon_Pagination_Item_Page', null, $params);
		$item_html = $this->getMock('Carbon_Pagination_Item_HTML', null, $params);
		$item_next_page = $this->getMock('Carbon_Pagination_Item_Next_Page', null, $params);
		$item_limiter = $this->getMock('Carbon_Pagination_Item_Limiter', null, $params);
		$item_number_links = $this->getMock('Carbon_Pagination_Item_Number_Links', null, $params);

		$collectionStub->set_items( array(
			$item,
			$item_page,
			$item_html,
			$item_next_page,
			$item_limiter,
			$item_number_links,	
		) );

		$item_page->expects( $this->any() )
			->method( 'get_page_number' )
			->will( $this->returnValue( 1 ) );

		foreach ($collectionStub->get_items() as $_item) {
			$paginationStub->add_tokens( $_item );
		}

		$this->assertArrayNotHasKey( 'TITLE', $item->get_tokens() );
		$this->assertArrayHasKey( 'TITLE', $item_page->get_tokens() );
		$this->assertArrayNotHasKey( 'TITLE', $item_html->get_tokens() );
		$this->assertArrayNotHasKey( 'TITLE', $item_next_page->get_tokens() );
		$this->assertArrayNotHasKey( 'TITLE', $item_limiter->get_tokens() );
		$this->assertArrayNotHasKey( 'TITLE', $item_number_links->get_tokens() );
	}

}