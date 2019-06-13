<?php

namespace Leroy\LeMVCS\ViewObjects\LeFormElements;

class Select extends ViewElementAbstract
{
    /** @var array */
    private $options;
    /** @var string */
    private $selected;

    /**
     * Select constructor.
     * @param string|null $name
     * @param string $selected
     * @param array $options
     * @param array $attr
     * @param array $style
     * @param string|null $id
     */
    public function __construct($name = null, $selected = '', array $options = [], $attr = [], $style = [], $id = null)
    {
        $this->options = $options;
        $this->selected = $selected;
        $this->attr = $attr;
        $this->style = $style;
        $this->attr["id"] = (!is_null($id)) ? $id : $name;
        $this->attr["name"] = $name;
    }

    /**
     * @param mixed $input
     */
    public function setSelected($input)
    {
        $this->selected = $input;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return str_replace(
            ["~options~", "~attr~", "~style~"],
            [
                $this->getOptions($this->options, $this->selected),
                $this->getAttr(),
                $this->getStyle()
            ],
            self::SELECT_HTML
        );
    }

    public function addOption($display, $value)
    {
        $this->options[$display] = $value;
        return $this;
    }

    public function addOptions(array $input)
    {
        if (!empty($input)) {
            foreach ($input as $display => $value) {
                $this->addOption($display, $value);
            }
        }
        return $this;
    }

    /**
     * @param array $ops
     * @param string $sVal
     * @return string
     */
    public function getOptions(array $ops, $sVal)
    {
        $output = "";
        $template = self::OPTION_HTML;
        foreach ($ops as $display => $value) {
            $selected = ($value == $sVal) ? "selected" : "";
            $output .= str_replace(
                array("~display~", "~val~", "~selected~"),
                array($display, $value, $selected),
                $template
            );
        }
        return $output;
    }
}
