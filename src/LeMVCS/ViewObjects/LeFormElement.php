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
    public static function button($name, $value = null, $attr = [], $style = [], $id = null)
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
    public static function checkbox($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function color($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function date($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function dateTime($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function dateTimeLocal($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function email($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function file($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function hidden($name, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $value, $attr, $style, $id);
    }

    /**
     * @param string $name
     * @param string|null $source
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function image($name, $source, $attr = [], $style = [], $id = null)
    {
        $attr['src'] = $source;
        return new Input(__FUNCTION__, $name, '', $attr, $style, $id);
    }

    /**
     * @param $for
     * @param $display
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Label
     */
    public function label($for, $display, $id = null, $attr = [], $style = [])
    {
        return new Label($for, $display, $id, $attr, $style);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function month($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function number($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function password($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function radio($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function range($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function reset($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function search($name, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $value, $attr, $style, $id);
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
    public function select($name, $selected = '', array $options = [], $attr = [], $style = [], $id = null)
    {
        return new Select($name, $selected, $options, $attr, $style, $id);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function submit($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function tel($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function text($name, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $value, $attr, $style, $id);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return TextArea
     */
    public function textArea($name, $value = null, $attr = [], $style = [], $id = null)
    {
        return new TextArea($name, $value, $attr, $style, $id);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function time($name, $value = null, $attr = [], $style = [], $id = null)
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
    public function url($name, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $value, $attr, $style, $id);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attr
     * @param array $style
     * @param string $id
     * @return Input
     */
    public function week($name, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $value, $attr, $style, $id);
    }
}
