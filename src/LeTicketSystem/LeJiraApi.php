<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/23/2019
 * Time: 8:02 PM
 */

namespace LeTicketSystem;


use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\IssueService;

class LeJiraApi implements LetTicketSystemInterface
{
    /**
     * @param array $errors
     * @param string $project
     * @param string $summary
     * @param string $priority
     * @param string $ticket_type
     * @return string
     */
    public function create(array $errors, $project, $summary, $priority, $ticket_type)
    {
        $description = [];
        $this->cycle($errors, $description);
        $issueField = new IssueField();
        $issueField->setProjectKey($project);
        $issueField->setSummary($summary);
        $issueField->setDescription(implode("\n", $description));
        $issueField->setPriorityName("High");
        $issueField->setIssueType("Bug");
        $issueService = new IssueService(null, null, '/var/www/PharmPay/UI/src/lib/bootstrap/');
        $ret = $issueService->create($issueField);

        //If success, Returns a link to the created issue.
        var_dump($ret);
        return $ret;
    }

    /**
     * @param array $arr
     * @param array $description
     * @param int $level
     */
    private function cycle(array $arr, array & $description, $level = 1) {
        foreach ($arr as $key => $val) {
            $symbol = 'h2';
            if (1 <= $level) {
                $symbol = '';
                for ($i = 1; $i <= $level; $i++) {
                    $symbol .= '*';
                }
            }
            if (is_array($val)) {
                if (!empty($val)) {
                    $this->cycle($val, $description, ++$level);
                } else {
                    $description[] = "{$symbol} {$key} = 'EMPTY'";
                }
            } else {
                $description[] = "{$symbol} {$key} = {$val}";
            }
        }
    }
}