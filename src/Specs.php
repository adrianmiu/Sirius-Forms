<?php
/**
 * Created by PhpStorm.
 * User: Florin
 * Date: 4/15/2014
 * Time: 11:10 PM
 */

namespace Sirius\Forms;


class Specs extends \ArrayObject{

    /**
     * Sets multiple attributes at once on the element
     * @param $attrs
     * @return self
     */
    function setAttributes($attrs) {
        return $this->setAttributesFor('', $attrs);
    }

    /**
     * Retrieves all attributes of the object
     * @return mixed
     */
    function getAttributes() {
        return $this->getAttributesFor('');
    }

    /**
     * Retrieves an attribute form the object
     *
     * @param $attr
     * @return mixed|NULL
     */
    function getAttribute($attr) {
        return $this->getAttributeFor('', $attr);
    }

    /**
     * Sets/Unsets an attribute on the object
     *
     * @param $attr
     * @param null $value
     * @return self
     */
    function setAttribute($attr, $value = null) {
        return $this->setAttributeFor('', $attr, $value);
    }

    /**
     * Adds a CSS class to the "class" attribute
     *
     * @param string $class
     * @return self
     */
    function addClass($class) {
        return $this->addClassFor('', $class);
    }

    /**
     * Removes a CSS class from the "class" attribute
     *
     * @param string
     * @return self
     */
    function removeClass($class) {
        return $this->removeClassFor('', $class);
    }

    /**
     * Toggles a CSS class from the "class" attribute
     *
     * @param string $class
     * @return self
     */
    function toggleClass($class) {
        return $this->toggleClassFor('', $class);
    }

    /**
     * Checks if the object has a CSS class
     *
     * @param string $class
     * @return bool
     */
    function hasClass($class) {
        return $this->hasClassOn('', $class);
    }

    /**
     * Adds a class on an attribute container
     * $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     *
     * @param string $target
     * @param string $className
     * @return self
     */
    protected function addClassFor($target, $className)
    {
        $class = $this->getAttributeFor($target, 'class') ? : '';
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
     * @return self
     */
    protected function removeClassFor($target, $className)
    {
        $class = $this->getAttributeFor($target, 'class') ? : '';
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
     * @return self
     */
    protected function toggleClassFor($target, $className)
    {
        $class = $this->getAttributeFor($target, 'class') ? : '';
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
     * Checks whether there is a CSS class on an attribute container
     * $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     *
     * @param $target
     * @param $className
     * @return bool
     */
    protected function hasClassOn($target, $className) {
        $class = $this->getAttributeFor($target, 'class') ? : '';
        $classesList = explode(' ', $class);
        return $className and in_array($className, $classesList);
    }

    /**
     * Set attributes on to an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     *
     * @param string $target (ex: NULL, label, hint etc)
     * @param array $attributes
     * @return self
     */
    protected function setAttributesFor($target, array $attributes)
    {
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
    protected function getAttributesFor($target)
    {
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
     * @return self
     */
    protected function setAttributeFor($target, $attribute, $value = null)
    {
        $target = strtolower($target);
        $key = 'attributes';
        if ($target) {
            $key = $target . '_attributes';
        }
        if (!isset($this[$key]) || !is_array($this[$key])) {
            $this[$key] = array();
        }
        if ($value === null) {
            $container = $this[$key];
            unset($container[$attribute]);
            $this[$key] = $container;
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
    protected function getAttributeFor($target, $attribute)
    {
        $attrs = $this->getAttributesFor($target);
        if (isset($attrs[$attribute])) {
            return $attrs[$attribute];
        }
        return null;
    }


}
