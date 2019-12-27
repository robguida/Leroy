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
