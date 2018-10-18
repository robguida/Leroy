<?php

namespace Leroy\LeMVCS\ViewObjects\LeFormElements;

abstract class ViewElementAbstract
{
    /** @var array */
    protected $style = [];
    /** @var array */
    protected $attr = [];

    const INPUT_HTML = "<input type=\"~type~\"~attr~~style~ />";
    const LABEL_HTML = "<label for=\"~for~\"~attr~~style~>~display~</label>";
    const TEXTAREA_HTML = "<textarea~attr~~style~>~display~</textarea>";
    const SELECT_HTML = "<select~attr~~style~>~options~</select>";
    const OPTION_HTML = "<option value=\"~val~\"~selected~>~display~</option>";

    public function __construct()
    {
    }

    /**
     * @return string
     */
    abstract public function toString();

    /**
     * @param string $name
     * @param string $val
     * @return ViewElementAbstract|Select|Input|Label|TextArea
     */
    public function setAttribute($name, $val)
    {
        $this->attr[$name] = $val;
        return $this;
    }

    /**
     * @param array $input
     * @return ViewElementAbstract
     */
    public function loadAttributes(array $input)
    {
        if (!empty($input)) {
            foreach ($input as $name => $val) {
                $this->setAttribute($name, $val);
            }
        }
        return $this;
    }

    /**
     * @param string $name
     * @param string $val
     * @return ViewElementAbstract
     */
    public function setStyle($name, $val)
    {
        $this->style[$name] = $val;
        return $this;
    }

    /**
     * @param array $input
     * @return ViewElementAbstract
     */
    public function loadStyles(array $input)
    {
        if (!empty($input)) {
            foreach ($input as $name => $val) {
                $this->setStyle($name, $val);
            }
        }
        return $this;
    }

    public function render()
    {
        echo $this->toString();
    }

    /**
     * @return string
     */
    protected function getAttr()
    {
        $output = '';
        if (!empty($this->attr) && is_array($this->attr)) {
            $params = [];
            foreach ($this->attr as $key => $val) {
                $params[] = "{$key}=\"{$val}\"";
            }
            $output = " " . implode(" ", $params);
        }
        return $output;
    }

    /**
     * @return string
     */
    protected function getStyle()
    {
        $output = '';
        if (!empty($this->style)) {
            $styles = [];
            foreach ($this->style as $key => $val) {
                $styles[] = "{$key}:{$val}";
            }
            $output = " style=\"" . implode(";", $styles) . "\"";
        }
        return $output;
    }
}
