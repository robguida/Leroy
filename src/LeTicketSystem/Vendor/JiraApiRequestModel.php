<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/26/2019
 * Time: 7:19 AM
 */

namespace Leroy\LeTicketSystem\Vendor;

use Leroy\LeTicketSystem\LeTicketSystemRequestModel;

class JiraApiRequestModel extends LeTicketSystemRequestModel
{
    /** @var string */
    private $project;
    /** @var string */
    private $path_to_credentials;

    const ISSUE_TYPE_BUG = 'Bug';
    const ISSUE_TYPE_EPIC = 'Epic';
    const ISSUE_TYPE_STORY = 'Story';
    const ISSUE_TYPE_SUB_TASK = 'Sub-task';
    const ISSUE_TYPE_TASK = 'Task';

    const PRIORITY_HIGHEST = 'Highest';
    const PRIORITY_HIGH = 'High';
    const PRIORITY_MEDIUM = 'Medium';
    const PRIORITY_LOW = 'Low';
    const PRIORITY_LOWEST = 'Lowest';

    /**
     * @return string
     */
    public function getProject(): string
    {
        return $this->project;
    }

    /**
     * @param string $project
     */
    public function setProject(string $project)
    {
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function getPathToCredentials()
    {
        return $this->path_to_credentials;
    }

    /**
     * @param mixed $path_to_credentials
     */
    public function setPathToCredentials($path_to_credentials)
    {
        $this->path_to_credentials = $path_to_credentials;
    }
}
