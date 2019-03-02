<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/10/2018
 * Time: 10:21 AM
 */

namespace Leroy\LeMVCS;

interface LeCrudControllerInterface
{
    /**
     * @param LeHttpRequest $request
     * @return mixed
     */
    public function create(LeHttpRequest $request);

    /**
     * @param mixed $id
     * @return array
     */
    public function read($id);

    /**
     * @param LeHttpRequest $request
     * @return mixed
     */
    public function update(LeHttpRequest $request);

    /**
     * @param mixed $id
     * @return boolean
     */
    public function delete($id);

    /**
     * @param mixed $id
     * @return boolean
     */
    public function archive($id);
}
