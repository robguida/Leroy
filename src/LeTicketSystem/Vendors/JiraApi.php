<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/23/2019
 * Time: 8:02 PM
 */

namespace Leroy\LeTicketSystem\Vendors;

use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\JiraException;
use Leroy\LeApi\LeApiResponseModel;
use Leroy\LeTicketSystem\LeTicketSystemInterface;
use Leroy\LeTicketSystem\LeTicketSystemRequestModel;
use Leroy\LeTicketSystem\LeTicketSystemApiAbstract;

class JiraApi extends LeTicketSystemApiAbstract implements LeTicketSystemInterface
{
    /**
     * @param LeTicketSystemRequestModel $model
     * @return LeApiResponseModel
     */
    public function create(LeTicketSystemRequestModel $model)
    {
        // TODO: Implement create() method.
        $output = new LeApiResponseModel();
        return $output;
    }

    /**
     * @param string|int $id
     * @return LeApiResponseModel
     */
    public function read($id)
    {
        // TODO: Implement read() method.
        $output = new LeApiResponseModel();
        return $output;
    }

    /**
     * @param string|int $id
     * @param LeTicketSystemRequestModel $model
     * @return LeApiResponseModel
     */
    public function update($id, LeTicketSystemRequestModel $model)
    {
        // TODO: Implement update() method.
        $output = new LeApiResponseModel();
        return $output;
    }

    /**
     * @param string|int $id
     * @return LeApiResponseModel
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
        $output = new LeApiResponseModel();
        return $output;
    }

    /**
     * @param string|int $id
     * @param array|string $comment
     * @return LeApiResponseModel
     */
    public function addComment($id, $comment)
    {
        // TODO: Implement addComment() method.
        $output = new LeApiResponseModel();
        return $output;
    }

    /**
     * @param string $criteria
     * @return LeApiResponseModel
     */
    public function find($criteria)
    {
        // TODO: Implement find() method.
        $output = new LeApiResponseModel();
        return $output;
    }
}