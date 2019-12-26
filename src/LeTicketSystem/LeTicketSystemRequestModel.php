<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/26/2019
 * Time: 7:09 AM
 */

namespace Leroy\LeTicketSystem;


class LeTicketSystemRequestModel
{
    /** @var string */
    private $title;
    /** @var array|string */
    private $description;
    /** @var string|integer */
    private $priority;
    /** @var string */
    private $ticket_type;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return array|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param array|string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int|string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int|string $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getTicketType(): string
    {
        return $this->ticket_type;
    }

    /**
     * @param string $ticket_type
     */
    public function setTicketType(string $ticket_type)
    {
        $this->ticket_type = $ticket_type;
    }
}