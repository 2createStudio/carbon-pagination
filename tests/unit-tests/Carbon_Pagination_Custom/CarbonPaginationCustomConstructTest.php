<?php
/**
 * @group pagination
 * @group pagination_custom
 * @group constructors
 */
class CarbonPaginationCustomConstructTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		$page_id = $this->factory->post->create(array(
			'post_type' => 'page',
			'post_content' => str_repeat("Test\n<!--nextpage-->\ntest", 4),
		));

		$this->go_to('/?page_id=' . $page_id . '&page=2');
		setup_postdata( get_post( $page_id ) );

		$paginationStub = $this->getMock( 'Carbon_Pagination_Custom', null );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset($this->pagination);

		parent::tearDown();
	}

	/**
	 * @covers Carbon_Pagination_Custom::__construct
	 */
	public function testDefaultArgsTotalPages() {
		$this->assertSame( 5, $this->pagination->get_total_pages() );
	}

	/**
	 * @covers Carbon_Pagination_Custom::__construct
	 */
	public function testDefaultArgsCurrentPage() {
		$this->assertSame( 2, $this->pagination->get_current_page() );
	}

	/**
	 * @covers Carbon_Pagination_Custom::__construct
	 */
	public function testCustomUnexistingArgs() {
		$args = array( 
			array( 
				'enable_numbers' => true
			)
		);
		$pagination = $this->getMock( 'Carbon_Pagination_Custom', null, $args );

		$this->assertSame( true, $pagination->get_enable_numbers() );
	}

	/**
	 * @covers Carbon_Pagination_Custom::__construct
	 */
	public function testCustomExistingArgs() {
		$args = array( 
			array( 
				'total_pages' => 20
			)
		);
		$pagination = $this->getMock( 'Carbon_Pagination_Custom', null, $args );

		$this->assertSame( 20, $pagination->get_total_pages() );
	}

}