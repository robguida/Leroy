<?php

namespace Leroy\LeMVCS\ViewObjects;

use Leroy\LeMVCS\ViewObjects\LeFormElements\Input;
use Leroy\LeMVCS\ViewObjects\LeFormElements\Label;
use Leroy\LeMVCS\ViewObjects\LeFormElements\Select;
use Leroy\LeMVCS\ViewObjects\LeFormElements\TextArea;

/**
 * Class LeFormElement
 * @package LeCore\Common\View\ViewFunction
 */
class LeFormElement
{
    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public static function button($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $value, $attr, $style, $id);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public static function checkbox($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Color($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Date($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function DateTime($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function DateTimeLocal($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Email($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function File($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Hidden($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Image($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Month($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Number($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Password($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Radio($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Range($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Reset($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Search($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Submit($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Tel($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Text($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Time($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function Url($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attr
     * @param array $style
     * @param string $id
     * @return Input
     */
    public function Week($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $id, $value, $attr, $style);
    }

    /**
     * @param $for
     * @param $display
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Label
     */
    public function Label($for, $display, $id = null, $attr = [], $style = [])
    {
        return new Label($for, $display, $id, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return TextArea
     */
    public function TextArea($name = null, $value = null, $attr = [], $style = [], $id = null)
    {
        return new TextArea($name, $value, $attr, $style, $id);
    }

    /**
     * @param string $name
     * @param string $selected
     * @param array $options
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Select
     */
    public function Select($name = null, $selected = '', array $options = [], $attr = [], $style = [], $id = null)
    {
        return new Select($name, $selected, $options, $attr, $style, $id);
    }
}
