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
    /** @var array */
    protected $prefix_values = [];

    /**
     * @param array $arr
     * @return string
     */
    protected function convertDescriptionIntoTicketBody(array $arr)
    {
        $description = [];
        $this->flattenDescriptionToSingleDimensionArray($arr, $description);
        $output = implode("\n", $description);
        return $output;
    }

    /**
     * @param array $arr
     * @param array $description
     * @param int $index
     */
    protected function flattenDescriptionToSingleDimensionArray(array $arr, array & $description, $index = 0)
    {
        if (0 == $index) {
            $prefix = $this->prefix_values[0];
        } else {
            $prefix = implode('', array_fill(0, $index, $this->prefix_values[1]));
        }
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                if (!empty($val)) {
                    $description[] = "{$prefix} {$key}";
                    $new_index = $index + 1;
                    $this->flattenDescriptionToSingleDimensionArray($val, $description, $new_index);
                } else {
                    $description[] = "{$prefix} {$key} = 'EMPTY'";
                }
            } else {
                $description[] = "{$prefix} {$key} = {$val}";
            }
        }
    }
}
