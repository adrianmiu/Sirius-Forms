<?php

namespace Sirius\Forms\Element;

use Sirius\Forms\Element as FormElement;

/**
 * @method \Sirius\Forms\Element\Specs getAttributes() Get the attributes for the input field
 * @method \Sirius\Forms\Element\Specs setAttributes(array $attributes) Set attributes for the input field
 * @method \Sirius\Forms\Element\Specs setAttribute($attr, $value = null) Set/Unset attribute for the input field
 * @method \Sirius\Forms\Element\Specs addClass($class) Add a CSS class  for the input field
 * @method \Sirius\Forms\Element\Specs removeClass($class) Removes a CSS class for the input field
 * @method \Sirius\Forms\Element\Specs toggleClass($class) Toggles a class  for the input field
 */
class Specs extends \ArrayObject {

	function __construct(array $specs = array()) {
		parent::__construct(array(), \ArrayObject::STD_PROP_LIST);
		foreach ($specs as $name => $value) {
			$this[$name] = $value;
		}
	}

	function __call($method, $args) {
		if ('get' === substr($method, 0, 3)) {
			if ('Attributes' === substr($method, -10)) {
				return $this->getAttributesFor(substr($method, 3, -10));
			}
			if ('Attribute' === substr($method, -9) && isset($args[0])) {
				return $this->getAttributeFor(substr($method, 3, -9), $args[0]);
			}
			$key = $this->inflectCameCaseToUnderscore(substr($method, 3));
			return $this[$key];
		}
		if ('set' === substr($method, 0, 3)) {
			if ('Attributes' === substr($method, -10) && isset($args[0])) {
				return $this->setAttributesFor(substr($method, 3, -10), $args[0]);
			}
			if ('Attribute' === substr($method, -9) && count($args) === 2) {
				return $this->setAttributeFor(substr($method, 3, -9), $args[0], $args[1]);
			}
			if (isset($args[0])) {
				$key = $this->inflectCameCaseToUnderscore(substr($method, 3));
				$this[$key] = $args[0];
			}
			return $this;
		}
		if ('Class' === substr($method, -5)) {
			if ('add' === substr($method, 0, 3)) {
				return $this->addClassFor(substr($method, 3, -5), $args[0]);
			}
			if ('remove' === substr($method, 0, 6)) {
				return $this->removeClassFor(substr($method, 6, -5), $args[0]);
			}
			if ('toggle' === substr($method, 0, 6)) {
				return $this->toggleClassFor(substr($method, 6, -5), $args[0]);
			}
		}

		throw new \BadMethodCallException("Method {$method}() does not exist for class " . __CLASS__);
	}

	/**
	 * Inflector helper method to be used by the __call() method to determine the appropriate target
	 * 
	 * @param string $string
	 * @return string
	 */
	protected function inflectCameCaseToUnderscore($string) {
		$string = preg_replace('/([A-Z])/', '_\1', $string);
		return trim(strtolower($string), '_');
	}

    /**
     * Adds a class on an attribute container
     * $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     * 
     * @param string $target
     * @param string $className
     * @return \Sirius\Forms\Element\Specs
     */
    protected function addClassFor($target, $className) {
    	$class = $this->getAttributeFor($target, 'class') ?: '';
    	if (!in_array($className, explode(' ', $class))) {
    		$class .= ' ' . $className;
    		$this->setAttributeFor($target, 'class', trim($class));
    	}
    	return $this;
    }

    /**
     * Remove a class from an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     * 
     * @param string $target (ex: NULL, label, hint etc)
     * @param string $className
     * @return \Sirius\Forms\Element\Specs
     */
    protected function removeClassFor($target, $className) {
    	$class = $this->getAttributeFor($target, 'class') ?: '';
    	$classesList = explode(' ', $class);
    	if (in_array($className, $classesList)) {
    		$classesList = array_diff($classesList, array($className));
    		$this->setAttributeFor($target, 'class', trim(implode(' ', $classesList)));
    	}
    	return $this;
    }

    /**
     * Toggles a class on an attribute container
     * $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     * 
     * @param string $target (ex: NULL, label, hint etc)
     * @param string $className
     * @return \Sirius\Forms\Element\Specs
     */
    protected function toggleClassFor($target, $className) {
    	$class = $this->getAttributeFor($target, 'class') ?: '';
    	$classesList = explode(' ', $class);
    	if (in_array($className, $classesList)) {
    		$classesList = array_diff($classesList, array($className));
    	} else {
    		$classesList[] = $className;
    	}
    	$this->setAttributeFor($target, 'class', trim(implode(' ', $classesList)));
    	return $this;
    }

    /**
     * Set attributes on to an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     * 
     * @param string $target (ex: NULL, label, hint etc)
     * @param array $attributes
     * @return \Sirius\Forms\Element\Specs
     */
    protected function setAttributesFor($target, array $attributes) {
    	foreach ($attributes as $attribute => $value) {
    		$this->setAttributeFor($target, $attribute, $value);
    	}
    	return $this;
    }

    /**
     * Retrieve attributes from an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     * 
     * @param string $target (ex: NULL, label, hint etc)
     * @return mixed
     */
    protected function getAttributesFor($target) {
    	$target = strtolower($target);
   		$key = 'attributes';
    	if ('' !== $target) {
    		$key = $target . '_attributes';
    	}
    	// ensure the attributes are an array
    	if (!isset($this[$key]) || !is_array($this[$key])) {
    		$this[$key] = array();
    	}
    	return $this[$key];
    }

    /**
     * Sets a single attribute on an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     * 
     * @param string $target (ex: NULL, label, hint etc)
     * @param string $attribute (ex: id, class, disabled)
     * @param mixed $value
     * @return \Sirius\Forms\Element\Specs
     */
    protected function setAttributeFor($target, $attribute, $value = null) {
    	$target = strtolower($target);
   		$key = 'attributes';
    	if ('' !== $target) {
    		$key = $target . '_attributes';
    	}
    	if (!isset($this[$key]) || !is_array($this[$key])) {
    		$this[$key] = array();
    	}
    	if ($value === null) {
    		unset($this[$key][$attribute]);
    		return $this;
    	}
    	$this[$key][$attribute] = $value;
    	return $this;
    }

    /**
     * Get a single attribute from an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     * 
     * @param string $target (ex: NULL, label, hint etc)
     * @param string $attribute (ex: id, class, disabled)
     * @return mixed|NULL
     */
    protected function getAttributeFor($target, $attribute) {
    	$attrs = $this->getAttributesFor($target);
    	if (isset($attrs[$attribute])) {
    		return $attrs[$attribute];
    	}
    	return null;
    }


}