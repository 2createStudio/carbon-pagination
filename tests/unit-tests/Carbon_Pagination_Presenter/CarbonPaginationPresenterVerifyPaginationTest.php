<?php
/**
 * @group presenter
 */
class CarbonPaginationPresenterVerifyPaginationTest extends WP_UnitTestCase {

	/**
	 * @covers Carbon_Pagination_Presenter::verify_pagination
	 */
	public function testUnexistingPaginationCollection() {
		$pagination_args = array(
			'collection' => 'foo',
		);
		$pagination = $this->getMockForAbstractClass( 'Carbon_Pagination', array( $pagination_args ) );
		$presenter_args = array(
			$pagination,
		);
		$presenter = $this->getMockForAbstractClass( 'Carbon_Pagination_Presenter', $presenter_args );

		$this->assertWPError( $presenter->verify_pagination() );
	}

	/**
	 * @covers Carbon_Pagination_Presenter::verify_pagination
	 */
	public function testUnexistingPaginationRenderer() {
		$pagination_args = array(
			'renderer' => 'foo',
		);
		$pagination = $this->getMockForAbstractClass( 'Carbon_Pagination', array( $pagination_args ) );
		$presenter_args = array(
			$pagination,
		);
		$presenter = $this->getMockForAbstractClass( 'Carbon_Pagination_Presenter', $presenter_args );

		$this->assertWPError( $presenter->verify_pagination() );
	}

	/**
	 * @covers Carbon_Pagination_Presenter::verify_pagination
	 */
	public function testWithOneTotalPage() {
		$pagination = $this->getMockForAbstractClass('Carbon_Pagination', array(), '', TRUE, TRUE, TRUE, array('get_total_pages'));
		$pagination->expects( $this->any() )
			->method( 'get_total_pages' )
			->will( $this->returnValue( 1 ) );

		$presenter_args = array(
			$pagination,
		);
		$presenter = $this->getMockForAbstractClass( 'Carbon_Pagination_Presenter', $presenter_args );

		$this->assertFalse( $presenter->verify_pagination() );
	}

	/**
	 * @covers Carbon_Pagination_Presenter::verify_pagination
	 */
	public function testWithMultiplePages() {
		$pagination = $this->getMockForAbstractClass('Carbon_Pagination', array(), '', TRUE, TRUE, TRUE, array('get_total_pages'));
		$pagination->expects( $this->any() )
			->method( 'get_total_pages' )
			->will( $this->returnValue( 2 ) );

		$presenter_args = array(
			$pagination,
		);
		$presenter = $this->getMockForAbstractClass( 'Carbon_Pagination_Presenter', $presenter_args );

		$this->assertTrue( $presenter->verify_pagination() );
	}

}