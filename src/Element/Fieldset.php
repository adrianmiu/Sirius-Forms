<?php
namespace Sirius\Forms\Element;

use \Sirius\Forms\Element;
use \Sirius\Forms\ElementContainer;
use \Sirius\Forms\ElementFactory;
use \Sirius\Forms\ElementFactoryAwareInterface;

/**
 * A fielset is a special kind of form element that has a namespace
 * If a fielset contains an address its name will be `address` and will contain
 * children like `street_name`, `city`, `zip_code` etc.
 * Children will be rendered as `address[street_name]`, `address[city]` etc
 */
class Fieldset extends Element implements ElementFactoryAwareInterface {
    use ElementContainer;
    
	/**
	 * @var \Sirius\Form\ElementFactory
	 */
	protected $elementFactory;
	

	protected function getDefaultSpecs() {
	    return 	$defaultSpecs = array(
    		Element::WIDGET => 'fieldset'
    	);
	}
	
	/**
     * Generate the namespaced field name of an element inside the  fielset
     * 
     * @param string $name
     * @return string
     */
    protected function getFullChildName($name) {
    	$firstOpenBracket = strpos($name, '[');
    	// the name is already at least 2 levels deep like street[name]
    	if ($firstOpenBracket !== -1) {
    		return $this->getName . '[' . str_replace('[', '][', $name, 1);
    	}
    	return $this->getName() . '[' . $name . ']';
    }
    
    function setElementFactory(ElementFactory $elementFactory)
    {
        $this->elementFactory = $elementFactory;
        return $this;
    }

    /**
     * Add an element to the fielset
     *
     * @param string $name
     * @param \Sirius\Forms\Element|array $specsOrElement
     * @throws \RuntimeException
     * @return \Sirius\Forms\Form
     */
    function add($name, $specsOrElement)
    {
        if ($this->getForm()->isPrepared()) {
            throw new \RuntimeException('You cannot add elements after the form has been prepared');
        }
        $name = $this->getFullChildName($name);
        $element = $specsOrElement;
        if (is_array($specsOrElement)) {
            $element = $this->getElementFactory()->createFromSpecs($name, $specsOrElement);
            $element->setForm($this);
        }
        if (!$element instanceof \Sirius\Forms\Element) {
            throw new \RuntimeException('Cannot create a form element based on the data provided');
        }
        return $this->addToElementContainer($name, $element);
    }
    
    /**
     * Retrieve an element by name
     *
     * @param string $name
     * @return \Sirius\Forms\Element
     */
    function get($name)
    {
        $name = $this->getFullChildName($name);
        return $this->getFromElementContainer($name);
    }
    
    /**
     * Removes an element from the fielset
     *
     * @param string $name
     * @throws \RuntimeException
     * @return \Sirius\Forms\Form
     */
    function remove($name)
    {
        if ($this->getForm()->isPrepared()) {
            throw new \RuntimeException('You cannot remove elements after the form has been prepared');
        }
        $name = $this->getFullChildName($name);
        return $this->removeFromElementContainer($name);
    }
    
    /**
     * Returns whether an element exist in the fielset
     *
     * @param string $name
     * @return boolean
     */
    function has($name)
    {
        $name = $this->getFullChildName($name);
        return false !== $this->get($name);
    }
    
    
}