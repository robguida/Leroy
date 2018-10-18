<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/20/18
 * Time: 9:43 PM
 */

namespace Leroy\LeMVCS;

use RobGuida\Leroy\Package\LeMVCS\ViewObjects\LeFormElement;
use RobGuida\Leroy\Package\LeMVCS\ViewObjects\LeFormElements\ViewElement\ViewElementAbstract;

class LeControllerAbstract
{
    /** @var string */
    private $template_url;

    /**
     * @return string
     */
    public function getTemplateUrl()
    {
        return $this->template_url;
    }

    /**
     * @param string $template_url
     */
    public function setTemplateUrl($template_url)
    {
        $this->template_url = $template_url;
    }

    /**
     * @param string $file
     * @param array|null $params
     * @return string
     */
    protected function loadTemplate($file, array $params = null)
    {
        $full_path = "{$this->getTemplateUrl()}{$file}";
        ob_start();
        /** @var ViewElementAbstract $Elements This will be available in the view file */
        $elements = new LeFormElement();
        if (0 < count($params)) {
             foreach ($params as $variable => $param) {
                $$variable = $param; // create the new variable using the class name
            }
            unset($params);// no longer needed
        }
        require_once($full_path);
        $output = ob_get_contents();
        ob_clean();
        return $output;
    }
}
