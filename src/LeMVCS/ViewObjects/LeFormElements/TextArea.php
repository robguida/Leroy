<?php

namespace Leroy\LeMVCS\ViewObjects\LeFormElements;

class TextArea extends ViewElementAbstract
{
    /** @var string */
    private $display;

    /**
     * TextArea constructor.
     * @param string|null $name
     * @param string|null $display
     * @param array $attr
     * @param array $style
     * @param string|null $id
     */
    public function __construct($name = null, $display = null, $attr = [], $style = [], $id = null)
    {
        $this->display = $display;
        $this->attr = $attr;
        $this->style = $style;
        $this->attr["id"] = (!is_null($id)) ? $id : $name;
        $this->attr["name"] = $name;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return str_replace(
            ["~display~", "~attr~", "~style~"],
            [
                $this->display,
                $this->getAttr(),
                $this->getStyle()
            ],
            self::TEXTAREA_HTML
        );
    }
}
