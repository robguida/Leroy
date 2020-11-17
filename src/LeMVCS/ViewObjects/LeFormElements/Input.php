<?php

namespace Leroy\LeMVCS\ViewObjects\LeFormElements;

class Input extends ViewElementAbstract
{
    /** @var string */
    private $type;

    /**
     * Input constructor.
     * @param string $type
     * @param string|null $name
     * @param string|null $value
     * @param array $attr
     * @param array $style
     * @param string|null $id
     */
    public function __construct(string $type, string $name = null, string $value = null, array $attr = [], array $style = [], string $id = null)
    {
        $this->type = $type;
        // set up the attributes
        $this->attr = $attr;
        $this->style = $style;
        $this->attr["id"] = (!is_null($id)) ? $id : $name;
        $this->attr["name"] = $name;
        if (!empty($value)) {
            $this->attr["value"] = $value;
        }
    }

    /**
     * @return string
     */
    public function toString()
    {
        return str_replace(
            ["~type~", "~attr~", "~style~"],
            [
                $this->type,
                $this->getAttr(),
                $this->getStyle()
            ],
            self::INPUT_HTML
        );
    }
} 