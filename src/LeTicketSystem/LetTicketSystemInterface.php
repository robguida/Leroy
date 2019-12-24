<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/23/2019
 * Time: 8:02 PM
 */

namespace LeTicketSystem;


interface LetTicketSystemInterface
{
    /**
     * @param array $errors
     * @param string $project
     * @param string $summary
     * @param string $priority
     * @param string $ticket_type
     * @return
     */
    public function create(array $errors, $project, $summary, $priority, $ticket_type);
}