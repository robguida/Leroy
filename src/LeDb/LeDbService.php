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
    private $statement_cache;
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
        $this->statement_cache = [];
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
    //</editor-fold>

    /**
     * @param string $sql
     * @param array $bindings
     * @param bool $associate
     * @return LeDbResultInterface
     */
    public function execute($sql, array $bindings = [], $associate = false)
    {
        /** @var LeDbResultInterface $output */
        $output = $this->getDbResult();
        try {
            $sql_type = $this->evalSql($sql);
            $pdo = $this->initPdo($sql_type);
            $stmt = $this->getStatement($sql, $pdo, !empty($bindings));
            if (!empty($bindings)) {
                if ($associate) {
                    foreach ($bindings as $key => $val) {
                        if (is_int($val)) {
                            $var_type = PDO::PARAM_INT;
                        } elseif (is_bool($val)) {
                            $var_type = PDO::PARAM_BOOL;
                        } elseif (is_null($val)) {
                            $var_type = PDO::PARAM_NULL;
                        } else {
                            $var_type = (65535 < strlen($val)) ? PDO::PARAM_STR : PDO::PARAM_LOB;
                        }
                        $stmt->bindValue(":{$key}", $val, $var_type);
                    }
                }
                $stmt->execute($bindings);
            }
            $output->setPdoStatement($stmt);
            if ('master' == $sql_type) {
                $output->setLastInsertId($pdo->lastInsertId());
            }
            if ($pdo->errorCode()) {
                $output->setErrorCode($pdo->errorCode());
            }
            if ($pdo->errorInfo()) {
                $output->setErrorInfo($pdo->errorInfo());
            }
        } catch (Exception $e) {
            $output->setException($e);
        }
        return $output;
    }
    //<editor-fold desc="Private Functions">

    /**
     * @param string $sql
     * @param PDO $pdo
     * @param bool $prepare
     * @return PDOStatement
     */
    private function getStatement($sql, PDO $pdo, $prepare = false)
    {
        $key = md5($sql);
        if (!array_key_exists($key, $this->statement_cache)) {
            if ($prepare) {
                $this->statement_cache[$key] = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            } else {
                $this->statement_cache[$key] = $pdo->query($sql);
            }
        }
        return $this->statement_cache[$key];
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
    //</editor-fold>
}
