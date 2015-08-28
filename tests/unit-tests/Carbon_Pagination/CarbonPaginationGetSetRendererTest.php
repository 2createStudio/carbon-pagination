<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetRendererTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_renderer
	 * @covers Carbon_Pagination::set_renderer
	 */
	public function testGetSetRenderer() {
		$html = 'FooBar';
		$this->pagination->set_renderer( $html );
		$this->assertSame( $html, $this->pagination->get_renderer() );
	}

}