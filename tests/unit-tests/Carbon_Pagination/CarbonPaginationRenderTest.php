<?php
/**
 * @group pagination
 */
class CarbonPaginationRenderTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	public function testWithEcho() {
		$this->assertNull( $this->pagination->render() );
		$this->assertNull( $this->pagination->render( true ) );
	}

	public function testWithoutEcho() {
		$this->assertSame( '', $this->pagination->render( false ) );
	}

}