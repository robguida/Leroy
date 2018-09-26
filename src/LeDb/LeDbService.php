<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/17/18
 * Time: 11:38 PM
 */

namespace LeroysBackside\LeDb;

use Exception;
use PDO;

class LeDbService
{
    /** @var LeDbResultInterface */
    private $resultObject;
    /** @var  array */
    private $connection_cache;

    /**
     * LeDbService constructor.
     */
    private function __construct()
    {
        $this->connection_cache = [];
    }

    public static function init($domain)
    {
       /* load the db settings file
          - needs to know the path to the file */

       /* upon execute */
       return new LeDbService();
    }

    //<editor-fold desc="Getter/Setter Functions">
    /**
     * @param LeDbResultInterface|null $resultObject
     */
    public function setDbResult(LeDbResultInterface $resultObject = null)
    {
        if (is_null($resultObject)) {
            $resultObject = new LeDbResult();
        }
        $this->resultObject = $resultObject;
    }

    /**
     * @return LeDbResultInterface
     */
    protected function getDbResult()
    {
        if (is_null($this->resultObject)) {
            $this->setDbResult();
        }
        return clone $this->resultObject;
    }

    /**
     * @param $qry
     * @param PDO $stmt
     */
    protected function cacheConnection($qry, PDO $stmt)
    {
        $key = md5($qry);
        if (!array_key_exists($key, $this->connection_cache)) {
            $this->connection_cache[$key] = $stmt;
        }
    }

    /**
     * @param $qry
     * @return bool|PDO
     */
    protected function getConnection($qry)
    {
        $output = false;
        $key = md5($qry);
        if (array_key_exists($key, $this->connection_cache)) {
            $output = $this->connection_cache[$key];
        }
        return $output;
    }
    //</editor-fold>

    public function execute($qry)
    {
        $output = $this->getDbResult();
        try {
            if (!$pdo = $this->getConnection($qry)) {
                $this->cacheConnection($qry, new PDO(''));
            }
        } catch (Exception $e) {
            $output->setException($e);
        }
        return $output;
    }
}
