<?php
/**
 * @group pagination
 * @group constructors
 */
class CarbonPaginationConstructTest extends WP_UnitTestCase {

	public function carbon_pagination_default_options($defaults) {
		$defaults['total_pages'] = 456;
		return $defaults;
	}

	/**
	 * @covers Carbon_Pagination::__construct
	 */
	public function testDefaultValues() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->assertSame( 1, $paginationStub->get_total_pages() );
	}

	/**
	 * @covers Carbon_Pagination::__construct
	 */
	public function testDefaultArgsOverDefaultValues() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array(), '', false );
		$paginationStub->default_args = array(
			'total_pages' => 123,
		);
		$paginationStub->__construct();
		$this->assertSame( 123, $paginationStub->get_total_pages() );
	}

	/**
	 * @covers Carbon_Pagination::__construct
	 */
	public function testDefaultValuesFilterOverDefaultArgs() {
		add_filter('carbon_pagination_default_options', array($this, 'carbon_pagination_default_options'));
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array(), '', false );
		$paginationStub->default_args = array(
			'total_pages' => 123,
		);
		$paginationStub->__construct();
		remove_filter('carbon_pagination_default_options', array($this, 'carbon_pagination_default_options'));

		$this->assertSame( 456, $paginationStub->get_total_pages() );
	}

	/**
	 * @covers Carbon_Pagination::__construct
	 */
	public function testParameterSettingOverDefaultValuesFilter() {
		$args = array(
			'total_pages' => 123,
		);
		add_filter('carbon_pagination_default_options', array($this, 'carbon_pagination_default_options'));
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array($args) );
		remove_filter('carbon_pagination_default_options', array($this, 'carbon_pagination_default_options'));

		$this->assertSame( 123, $paginationStub->get_total_pages() );
	}

	/**
	 * @covers Carbon_Pagination::__construct
	 */
	public function testManualSettingOverParameterSetting() {
		$args = array(
			'total_pages' => 123,
		);
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination', array($args) );
		$paginationStub->set_total_pages(789);

		$this->assertSame( 789, $paginationStub->get_total_pages() );
	}

}