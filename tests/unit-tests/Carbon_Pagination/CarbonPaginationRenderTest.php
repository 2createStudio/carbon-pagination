<?php

class CarbonPaginationRenderTest extends WP_UnitTestCase {

	public function testRenderUnexistingPaginationCollection() {
		$args = array(
			'collection' => 'foo',
		);
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array($args) );
		$this->assertWPError( $paginationStub->render( false ) );
	}

	public function testRenderUnexistingPaginationRenderer() {
		$args = array(
			'renderer' => 'foo',
		);
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array($args) );
		$this->assertWPError( $paginationStub->render( false ) );
	}

}