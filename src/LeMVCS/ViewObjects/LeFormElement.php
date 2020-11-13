<?php

namespace Leroy\LeMVCS\ViewObjects;

use Leroy\LeMVCS\ViewObjects\LeFormElements\Input;
use Leroy\LeMVCS\ViewObjects\LeFormElements\Label;
use Leroy\LeMVCS\ViewObjects\LeFormElements\Multi;
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
    public static function button(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public static function checkbox(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function color(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function date(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function dateTime(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function dateTimeLocal(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function email(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function file(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function hidden(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function image(string $name, $source, $attr = [], $style = [], $id = null)
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
    public function month(string $name, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $value, $attr, $style, $id);
    }

    /**
     * @param string $name
     * @param array $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Multi
     */
    public function multi(string $name, $value = [], $attr = [], $style = [], $id = null)
    {
        return new Multi($name, $value, $attr, $style, $id);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     * @return Input
     */
    public function number(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function password(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function radio(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function range(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function reset(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function search(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function select(string $name, $selected = '', array $options = [], $attr = [], $style = [], $id = null)
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
    public function submit(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function tel(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function text(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function textArea(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function time(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function url(string $name, $value = null, $attr = [], $style = [], $id = null)
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
    public function week(string $name, $value = null, $attr = [], $style = [], $id = null)
    {
        return new Input(__FUNCTION__, $name, $value, $attr, $style, $id);
    }
}
