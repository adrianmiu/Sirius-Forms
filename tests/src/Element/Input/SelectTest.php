<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input;
use Mockery as m;

class SelectTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Sirius\Filtration\Filtrator
     */
    protected $filtrator;

    /**
     * @var \Sirius\Forms\Form
     */
    protected $form;

    /**
     * @var Select
     */
    protected $input;

    function setUp()
    {
        $this->filtrator = m::mock('\Sirius\Filtration\Filtrator');
        $this->form = new \Sirius\Forms\Form(null, null, $this->filtrator);
        $this->input = new Select('select');
        $this->input->setOptions(array(
            'a' => 'A',
            'b' => 'B'
        ));
    }

    function tearDown()
    {
        m::close();
    }

    function testDefaults()
    {

        $this->assertEquals('select', $this->input[ Input::WIDGET ]);
    }


    function testPrepareFormFiltration()
    {
        $this->filtrator->shouldReceive('getFilters');
        $this->filtrator->shouldReceive('add')
            ->with(
                'select',
                'callback',
                array(
                    'callback' => array($this->input, 'filterValue')
                )
            );
        $this->form->add('select', $this->input);
        $this->form->prepare();
    }

    function testFilterValue() {
        $this->assertEquals('a', $this->input->filterValue('a'));
        $this->assertEquals(null, $this->input->filterValue('c'));
    }
}
