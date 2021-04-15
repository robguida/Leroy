<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/20/18
 * Time: 9:43 PM
 */

namespace Leroy\LeMVCS;

use InvalidArgumentException;
use Leroy\LeMVCS\ViewObjects\LeFormElement;
use Leroy\LeMVCS\ViewObjects\LeViewTools;

/**
 * Class LeControllerAbstract
 * @package Leroy\LeMVCS
 */
abstract class LeControllerAbstract
{
    private string $template_url;

    /**
     * @return string
     */
    public function getTemplateUrl(): string
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
     * @return false|string
     */
    protected function getFullFilePath(string $file)
    {
        $output = "{$this->getTemplateUrl()}{$file}";
        if (!file_exists($output)) {
            $output = false;
        }
        return $output;
    }

    /**
     * @param string $file
     * @param array|null $params
     * @return string
     * @noinspection PhpIncludeInspection
     */
    protected function loadTemplate(string $file, array $params = null): string
    {
        if (!$full_file_path = $this->getFullFilePath($file)) {
            throw new InvalidArgumentException("The file does not exist: {$full_file_path}.");
        }
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
        require $full_file_path;
        $output = ob_get_contents();
        ob_clean();
        return $output;
    }
}
