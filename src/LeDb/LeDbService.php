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
use PDOStatement;

class LeDbService
{
    /** @var LeDbResultInterface */
    private $resultObject;
    /** @var  array */
    private $connection_cache;
    /** @var  array */
    private $pdo_cache;
    /** @var  string */
    private $domain_credentials;

    /**
     * LeDbService constructor.
     * @param string $domain_name - used to find the file with the db credentials
     * @param string $data_source_name - the dsn to use
     * @throws Exception
     */
    public function __construct($domain_name, $data_source_name)
    {
        $this->connection_cache = [];
        $this->pdo_cache = [];
        $this->domain_credentials = $this->getDomainCredentials($domain_name, $data_source_name);
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
    protected function cachePdo($qry, PDO $stmt)
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
    protected function getPdo($qry)
    {
        $output = false;
        $key = md5($qry);
        if (array_key_exists($key, $this->connection_cache)) {
            $output = $this->connection_cache[$key];
        }
        return $output;
    }
    //</editor-fold>

    /**
     * @param string $sql
     * @param array $bindings
     * @param bool $associate
     * @return LeDbResultInterface
     */
    public function execute($sql, array $bindings = [], $associate = false)
    {
        /**
         * @var PDOStatement $stmt
         */
        $output = $this->getDbResult();
        try {
            /* cache the pdo for each sql query */
            if (!$pdo = $this->getPdo($sql)) {
                $type = $this->evalSql($sql);
                $this->cachePdo($sql, $this->initPdo($type));
                $pdo = $this->getPdo($sql);
                if (!empty($bindings)) {
                    $stmt = $pdo->prepare($sql, [$pdo::ATTR_CURSOR, $pdo::CURSOR_FWDONLY]);
                }
            }
            if (!empty($bindings)) {
                if ($associate) {
                    foreach ($bindings as $key => $val) {
                        if (is_int($val)) {
                            $type = PDO::PARAM_INT;
                        } elseif (is_bool($val)) {
                            $type = PDO::PARAM_BOOL;
                        } elseif (is_null($val)) {
                            $type = PDO::PARAM_NULL;
                        } else {
                            $type = (65535 < strlen($val)) ? PDO::PARAM_STR : PDO::PARAM_LOB;
                        }
                        $stmt->bindValue(":{$key}", $val, $type);
                    }
                }
                $stmt->execute($sql, $bindings);
            } else {
                $stmt = $pdo->query($sql);
            }
        } catch (Exception $e) {
            $output->setException($e);
        }
        return $output;
    }

    /**
     * @param string $domain
     * @param string $dsn
     * @return string
     * @throws Exception
     */
    private function getDomainCredentials($domain, $dsn)
    {
        if (!file_exists($domain)) {
            throw new Exception("'{$domain}' does not exist");
        }
        $json_string = file_get_contents($domain);
        $stdClass = json_decode($json_string);
        return $stdClass->$dsn;
    }

    /**
     * @param $type
     * @return PDO
     */
    private function initPdo($type)
    {
        if ('master' == $type) {
            $cred = $this->domain_credentials->master;
        } else {
            $slaves = (array)$this->domain_credentials->slave;
            $slave = rand(0, count($slaves) - 1);
            $cred = $slaves[$slave];
        }
        $conn_str = "mysql:host={$cred->host};dbname={$cred->dbName};port={$cred->port};";
        if (!array_key_exists($conn_str, $this->pdo_cache)) {
            $this->pdo_cache[$conn_str] = new PDO(
                $conn_str,
                $cred->userName,
                $cred->password,
                [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_FOUND_ROWS => true
                ]
            );
        }
        return $this->pdo_cache[$conn_str];
    }

    /**
     * @param string $sql
     * @return string
     */
    private function evalSql($sql)
    {
        $parts = explode(' ', trim($sql));
        $first_word = current($parts);
        if (strtolower($first_word) === 'select') {
            $output = 'slave';
        } else {
            $output = 'master';
        }
        return $output;
    }
}
