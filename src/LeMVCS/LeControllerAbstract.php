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
    private string $template_path;

    /**
     * @return string
     * @deprecated
     */
    public function getTemplateUrl(): string
    {
        return $this->template_path;
    }

    /**
     * @param string $template_path
     * @deprecated
     */
    public function setTemplateUrl(string $template_path)
    {
        $this->template_path = $template_path;
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->template_path;
    }

    /**
     * @param string $template_path
     */
    public function setTemplatePath(string $template_path)
    {
        $this->template_path = $template_path;
    }


    /**
     * @param string $file
     * @return false|string
     * @throws InvalidArgumentException
     */
    protected function getFullFilePath(string $file): string
    {
        $output = "{$this->getTemplatePath()}{$file}";
        if (!file_exists($output)) {
            throw new InvalidArgumentException("The file does not exist: {$output}.");
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
        $full_file_path = $this->getFullFilePath($file);
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
