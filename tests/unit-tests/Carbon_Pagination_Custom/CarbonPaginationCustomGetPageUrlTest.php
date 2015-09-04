<?php
/**
 * @group pagination
 * @group pagination_custom
 */
class CarbonPaginationCustomGetPageUrlTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		$this->page_id = $this->factory->post->create(array(
			'post_type' => 'page',
			'post_content' => str_repeat("Test\n<!--nextpage-->\ntest", 9),
		));

		$this->go_to('/?page_id=' . $this->page_id);
		setup_postdata( get_post( $this->page_id ) );

		$this->pagination = $this->getMock( 'Carbon_Pagination_Custom', null );
	}

	public function tearDown() {
		unset($this->page_id);
		unset($this->pagination);
		parent::tearDown();
	}

	/**
	 * @covers Carbon_Pagination_Custom::get_page_url
	 */
	public function testGetPageUrlDefault() {
		$expected = home_url('/?page_id=' . $this->page_id . '&page=' . 5);
		$actual = $this->pagination->get_page_url( 4 );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Custom::get_page_url
	 */
	public function testGetPageUrlWithOldUrl() {
		$expected = 'http://example.org/test/?page=3';
		$actual = $this->pagination->get_page_url( 2, 'http://example.org/test/' );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Custom::get_page_url
	 */
	public function testGetPageUrlFirstPage() {
		$expected = home_url('/?page_id=' . $this->page_id . '&page=1');
		$actual = $this->pagination->get_page_url( 0 );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Custom::get_page_url
	 */
	public function testGetPageUrlLargeUnexistingPage() {
		$expected = home_url('/?page_id=' . $this->page_id);
		$actual = $this->pagination->get_page_url( 20 );
		$this->assertSame( $expected, $actual );
	}

}