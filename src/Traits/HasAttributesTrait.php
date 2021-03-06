<?php
namespace Sirius\Input\Traits;

use Sirius\Input\Specs;
use Sirius\Input\AttributesContainer;

trait HasAttributesTrait
{

    protected function ensureAttributes()
    {
        if (!isset($this[Specs::ATTRIBUTES])) {
            $this[Specs::ATTRIBUTES] = new AttributesContainer();
        }
    }

    /**
     * Retrieve all of the label's attributes
     *
     * @return mixed
     */
    public function getAttributes()
    {
        $this->ensureAttributes();

        return $this[Specs::ATTRIBUTES]->getAll();
    }

    /**
     * Sets multiple attributes for the label
     *
     * @param array $attrs
     *
     * @return HasAttributesTrait
     */
    public function setAttributes($attrs)
    {
        $this->ensureAttributes();
        $this[Specs::ATTRIBUTES]->set($attrs);

        return $this;
    }

    /**
     * Retrieve an attribute from the label
     *
     * @param string $attr
     *
     * @return mixed
     */
    public function getAttribute($attr)
    {
        $this->ensureAttributes();

        return $this[Specs::ATTRIBUTES]->get($attr);
    }

    /**
     * Set/Unset a label attribute
     *
     * @param string $attr
     * @param string $value
     *
     * @return self
     */
    public function setAttribute($attr, $value = null)
    {
        $this->ensureAttributes();
        $this[Specs::ATTRIBUTES]->set($attr, $value);

        return $this;
    }

    /**
     * Adds a CSS class to the label's "class" attribute
     *
     * @param string $class
     *
     * @return self
     */
    public function addClass($class)
    {
        $this->ensureAttributes();
        $this[Specs::ATTRIBUTES]->addClass($class);

        return $this;
    }

    /**
     * Removes a CSS class from the label's "class" attribute
     *
     * @param string $class
     *
     * @return self
     */
    public function removeClass($class)
    {
        $this->ensureAttributes();
        $this[Specs::ATTRIBUTES]->removeClass($class);

        return $this;
    }

    /**
     * Toggles a CSS class to the label's "class" attribute
     *
     * @param
     *            $class
     *
     * @return self
     */
    public function toggleClass($class)
    {
        $this->ensureAttributes();
        $this[Specs::ATTRIBUTES]->toggleClass($class);

        return $this;
    }

    /**
     * Checks if the label has a CSS class on the "class" attribute
     *
     * @param
     *            $class
     *
     * @return bool
     */
    public function hasClass($class)
    {
        $this->ensureAttributes();

        return $this[Specs::ATTRIBUTES]->hasClass($class);
    }

}