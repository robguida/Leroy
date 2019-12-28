<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/23/2019
 * Time: 8:02 PM
 */

namespace Leroy\LeTicketSystem\Vendor;

use Exception;
use InvalidArgumentException;
use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\JiraException;
use Leroy\LeApi\LeApiResponseModel;
use Leroy\LeTicketSystem\LeTicketSystemInterface;
use Leroy\LeTicketSystem\LeTicketSystemRequestModel;
use Leroy\LeTicketSystem\LeTicketSystemApiAbstract;

class JiraApi extends LeTicketSystemApiAbstract implements LeTicketSystemInterface
{
    public function __construct()
    {
        $this->prefix_values = ["\nh1.", '*'];
        $this->vendor = 'Jira';
    }

    /**
     * @param LeTicketSystemRequestModel $model
     * @return LeApiResponseModel
     */
    public function create(LeTicketSystemRequestModel $model)
    {
        // TODO: Implement create() method.
        $output = new LeApiResponseModel();
        try {
            if (!$model instanceof JiraApiRequestModel) {
                throw new InvalidArgumentException('JiraApiRequestModel required to create a ticket');
            }
            $description = $model->getDescription();
            if (!is_string($description)) {
                $description = $this->convertDescriptionIntoTicketBody($description);
            }
            $issueField = new IssueField();
            $issueField->setProjectKey($model->getProject());
            $issueField->setSummary($model->getTitle());
            $issueField->setDescription($description);
            $issueField->setPriorityName($model->getPriority());
            $issueField->setIssueType($model->getTicketType());
            $issueService = new IssueService(null, null, $model->getPathToCredentials());
            $ret = $issueService->create($issueField);
            $output->setData($ret->key);

        } catch (JiraException $e) {
            $output->setException($e);
        }
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
        try {
            if (!$model instanceof JiraApiRequestModel) {
                throw new InvalidArgumentException('JiraApiRequestModel required to create a ticket');
            }
        } catch (Exception $e) {
            $output->setException($e);
        }
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
     * @param LeTicketSystemRequestModel $model
     * @return LeApiResponseModel
     */
    public function find(LeTicketSystemRequestModel $model)
    {
        // TODO: Implement find() method.
        $output = new LeApiResponseModel();
        try {
            if (!$model instanceof JiraApiRequestModel) {
                throw new InvalidArgumentException('JiraApiRequestModel required to create a ticket');
            }
        } catch (Exception $e) {
            $output->setException($e);
        }
        return $output;
    }
}
