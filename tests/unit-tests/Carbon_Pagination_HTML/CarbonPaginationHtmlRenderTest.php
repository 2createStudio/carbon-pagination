<?php
/**
 * @group pagination
 * @group pagination_html
 */
class CarbonPaginationHtmlRenderTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::render
	 */
	public function testWithEcho() {
		$this->assertNull( $this->pagination->render() );
		$this->assertNull( $this->pagination->render( true ) );
	}

	/**
	 * @covers Carbon_Pagination::render
	 */
	public function testWithoutEcho() {
		$this->assertSame( '', $this->pagination->render( false ) );
	}

}