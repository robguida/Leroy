<?php

namespace Leroy\LeMVCS\ViewObjects\LeFormElements;

class Label extends ViewElementAbstract
{
    /** @var string */
    private $for;
    /** @var string */
    private $display;

    /**
     * Label constructor.
     * @param string $for
     * @param string $display
     * @param int|null $id
     * @param array $attr
     * @param array $style
     */
    public function __construct($for, $display, $id = null, $attr = [], $style = [])
    {
        $this->for = $for;
        $this->display = $display;
        $this->attr = $attr;
        $this->style = $style;
        $this->attr['id'] = $id;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return str_replace(
            ["~for~", "~display~", "~attr~", "~style~"],
            [
                $this->for,
                $this->display,
                $this->getAttr(),
                $this->getStyle()
            ],
            self::LABEL_HTML
        );
    }
}
