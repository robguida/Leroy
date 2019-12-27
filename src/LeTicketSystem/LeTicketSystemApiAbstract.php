<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/26/2019
 * Time: 6:40 AM
 */

namespace Leroy\LeTicketSystem;

/**
 * Class LeTicketSystemApiAbstract
 * @package Leroy\LeTicketSystem
 */
abstract class LeTicketSystemApiAbstract
{
    /**
     * @param array $arr
     * @return string
     */
    protected function convertArrayIntoTicketBody(array $arr)
    {
        return implode("\n", $arr);
    }
}
