<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/23/2019
 * Time: 8:01 PM
 */

namespace Leroy\LeTicketSystem;

use Leroy\LeApi\LeApiResponseModel;
use Leroy\LeTicketSystem\Vendor\JiraApi;
use Leroy\LeTicketSystem\Vendor\JiraApiRequestModel;

/**
 * Class LeTicketSystemFactory
 * @package Leroy\LeTicketSystem
 */
class LeTicketSystemFactory
{
    const TS_JIRA = 'Jira';

    /**
     * @param string $ticket_system
     * @return LeTicketSystemInterface
     */
    public static function init($ticket_system = self::TS_JIRA)
    {
        $class = "Leroy\\LeTicketSystem\\Vendor\\{$ticket_system}Api";
        return new $class;
    }

    /**
     * @param string $credentials
     * @param string $project
     * @param string $summary
     * @param string $description
     * @param string $priority
     * @return LeApiResponseModel
     */
    public static function createJiraBug($credentials, $project, $summary, $description, $priority = null)
    {
        $api = new JiraApi();
        $requestModel = new JiraApiRequestModel();
        if (is_null($priority)) {
            $priority = $requestModel::PRIORITY_HIGHEST;
        }
        $requestModel->setProject($project);
        $requestModel->setTitle($summary);
        $requestModel->setDescription($description);
        $requestModel->setPriority($priority);
        $requestModel->setTicketType($requestModel::ISSUE_TYPE_BUG);
        $requestModel->setPathToCredentials($credentials);
        return $api->create($requestModel);
    }
}
