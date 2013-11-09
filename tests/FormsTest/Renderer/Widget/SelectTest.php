<?php

namespace Sirius\FormsTest\Renderer\Widget;


use Sirius\Forms\Renderer\Widget\Select;

class SelectTest extends \PHPUnit_Framework_TestCase {
	
	function setUp() {
		$this->input = new Select(array(
			'name' => 'answer',
			'value' => 'maybe',
			'attrs' => array(
				'class' => 'dropdown'
			),
			'data' => array(
				'first_option' => '--select--',
				'options' => array(
					'yes' => 'Yes',
					'no' => 'No',
					'maybe' => 'Maybe',	
				)
			)
		));
	}

	function testRender() {
		$result = (string) $this->input;
		$this->assertTrue(strpos($result, '<option value="maybe" selected="selected">Maybe</option>') !== false);
		$this->assertTrue(strpos($result, '<option value="yes" >Yes</option>') !== false);
	}
	
}