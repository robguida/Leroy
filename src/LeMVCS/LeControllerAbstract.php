<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/20/18
 * Time: 9:43 PM
 */

namespace Leroy\LeMVCS;

use Leroy\LeMVCS\ViewObjects\LeFormElement;
use Leroy\LeMVCS\ViewObjects\LeViewTools;

/**
 * Class LeControllerAbstract
 * @package Leroy\LeMVCS
 */
abstract class LeControllerAbstract
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
    public function setTemplateUrl(string $template_url)
    {
        $this->template_url = $template_url;
    }

    /**
     * @param string $file
     * @param array|null $params
     * @return string
     * @noinspection PhpIncludeInspection
     */
    protected function loadTemplate(string $file, array $params = null)
    {
        $full_path = "{$this->getTemplateUrl()}{$file}";
        ob_start();
        if ($params) {
            foreach ($params as $variable => $param) {
                $$variable = $param; // create the new variable using the class name
            }
            unset($params);// no longer needed
        }
        /** @var LeFormElement $LeElements This will be available in the view file */
        if (!isset($leFormElements)) {
            $leFormElements = new LeFormElement();
        }
        /** @var LeViewTools $LeTools This will be available in the view file */
        if (!isset($leViewTools)) {
            $leViewTools = new LeViewTools();
        }
        require $full_path;
        $output = ob_get_contents();
        ob_clean();
        return $output;
    }
}
