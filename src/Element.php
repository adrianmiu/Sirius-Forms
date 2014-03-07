<?php
namespace Sirius\Forms;

use Sirius\Forms\Form;

/**
 * @method \Sirius\Forms\Element getAttributes() Get the attributes for the input field
 * @method \Sirius\Forms\Element setAttributes(array $attributes) Set attributes for the input field
 * @method \Sirius\Forms\Element setAttribute($attr, $value) Set attribute for the input field
 * @method \Sirius\Forms\Element addClass($class) Add a CSS class  for the input field
 * @method \Sirius\Forms\Element removeClass($class) Removes a CSS class for the input field
 * @method \Sirius\Forms\Element toggleClass($class) Toggles a class  for the input field
 * @method \Sirius\Forms\Element getLabel() Get the label text
 * @method \Sirius\Forms\Element setLabel($label) Set label text
 * @method \Sirius\Forms\Element getLabelAttributes() Get the attributes for the label
 * @method \Sirius\Forms\Element setLabelAttributes(array $attributes) Set label attributes
 * @method \Sirius\Forms\Element setLabelAttribute($attr, $value) Set label attribute
 * @method \Sirius\Forms\Element addLabelClass($class) Add a CSS class to the label
 * @method \Sirius\Forms\Element removeLabelClass($class) Removes a CSS class from the label
 * @method \Sirius\Forms\Element toggleLabelClass($class) Toggles a class on the label
 * @method \Sirius\Forms\Element getHint() Get the hint text
 * @method \Sirius\Forms\Element setHint($label) Set hint text
 * @method \Sirius\Forms\Element getHintAttributes() Get the attributes for the hint
 * @method \Sirius\Forms\Element setHintAttributes(array $attributes) Set hint attributes
 * @method \Sirius\Forms\Element setHintAttribute($attr, $value) Set hint attribute
 * @method \Sirius\Forms\Element addHintClass($class) Add a CSS class to the hint
 * @method \Sirius\Forms\Element removeHintClass($class) Removes a CSS class from the hint
 * @method \Sirius\Forms\Element toggleHintClass($class) Toggles a class on the hint
 * @method \Sirius\Forms\Element getContainerAttributes() Get the attributes for the container
 * @method \Sirius\Forms\Element setContainerAttributes(array $attributes) Set container attributes
 * @method \Sirius\Forms\Element setContainerAttribute($attr, $value) Set container attribute
 * @method \Sirius\Forms\Element addContainerClass($class) Add a CSS class to the container
 * @method \Sirius\Forms\Element removeContainerClass($class) Removes a CSS class from the container
 * @method \Sirius\Forms\Element toggleContainerClass($class) Toggles a class on the container
 */
class Element extends Element\Specs
{
    /**
     * Constants to be used by setSpec(), getXXX(), setXXX()
     */
    const ATTRIBUTES = 'attributes';
    const LABEL = 'label';
    const LABEL_ATTRIBUTES = 'label_attributes';
    const PRIORITY = 'priority';
    const PARENT = 'parent';
    const CONTAINER_ATTRIBUTES = 'container_attributes';
    const HINT = '';
    const HINT_ATTRIBUTES = 'hint_attributes';
    const VALIDATION_RULES = 'validation_rules';
    const FILTERS = 'filters';
    const WIDGET = 'widget';

    /**
     *
     * @var \Sirius\Forms\Form
     */
    protected $form;

    /**
     * Name of the field (identifier of the element in the form's child list)
     * @var string
     */
    protected $name;

    protected $value;

    protected $specs;

    protected $error;

    /**
     *
     * @param string $name
     *            Name of the form element that will make it identifiable
     * @param array $specs
     *            Specification for the element (attributes, parents, etc)
     */
    function __construct($name, $specs = array())
    {
        parent::__construct($specs);
        $this->name = $name;
    }

    function __call($method, $args) {
        call_user_func_array(array($this->specs, $method), $args);
        return $this;
    }

    function setForm(\Sirius\Forms\Form $form)
    {
        $this->form = $form;
        return $this;
    }

    /**
     *
     * @return \Sirius\Forms\Form;
     */
    function getForm()
    {
        return $this->form;
    }

    protected function setValue($value)
    {}

    protected function getValue()
    {}

    protected function getRawValue()
    {}

    protected function setError($error)
    {}

    protected function getError()
    {}

}