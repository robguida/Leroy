<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/23/2019
 * Time: 8:01 PM
 */

namespace Leroy\LeTicketSystem;

use Prophecy\Doubler\ClassPatch\ReflectionClassNewInstancePatch;

class LeTicketSystemFactory
{
    const TS_JIRA = 'Jira';

    /**
     * @param string $ticket_system
     * @return LeTicketSystemInterface
     */
    public static function init($ticket_system = self::TS_JIRA)
    {
        $class = "Leroy\\LeTicketSystem\\{$ticket_system}Api";
        return new $class;
    }
}
