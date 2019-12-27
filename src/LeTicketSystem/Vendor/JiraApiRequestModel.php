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
}