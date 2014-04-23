<?php

namespace Sirius\Forms\Element\Button;

use Sirius\Forms\Element;

class ResetTest extends \PHPUnit_Framework_TestCase
{

    function testDefaults()
    {
        $input = new Reset('reset');

        $this->assertEquals('button', $input[Element::WIDGET]);
        $this->assertEquals('reset', $input[Element::ATTRIBUTES]['type']);
    }

}