<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/23/2019
 * Time: 8:02 PM
 */

namespace Leroy\LeTicketSystem;


use Leroy\LeApi\LeApiResponseModel;

interface LeTicketSystemInterface
{
    /**
     * @param LeTicketSystemRequestModel $model
     * @return LeApiResponseModel
     */
    public function create(LeTicketSystemRequestModel $model);

    /**
     * @param string|int $id
     * @return LeApiResponseModel
     */
    public function read($id);

    /**
     * @param string|int $id
     * @param LeTicketSystemRequestModel $model
     * @return LeApiResponseModel
     */
    public function update($id, LeTicketSystemRequestModel $model);

    /**
     * @param string|int $id
     * @return LeApiResponseModel
     */
    public function delete($id);

    /**
     * @param string|int $id
     * @param array|string $comment
     * @return LeApiResponseModel
     */
    public function addComment($id, $comment);

    /**
     * @param LeTicketSystemRequestModel $model
     * @return LeApiResponseModel
     */
    public function find(LeTicketSystemRequestModel $model);
}