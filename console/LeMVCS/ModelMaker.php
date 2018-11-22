<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/21/2018
 * Time: 10:15 PM
 */

namespace LeroyConsole\LeMVCS;

use Exception;
use InvalidArgumentException;
use PDO;
use PDOStatement;

class ModelMaker
{
    /** @var string */
    private $destination_path;
    /** @var string */
    private $host;
    /** @var string */
    private $db_name;
    /** @var int */
    private $port;
    /** @var string */
    private $table_name;
    /** @var string */
    private $user_name;
    /** @var string */
    private $password;
    /** @var string */
    private $author;
    /** @var string */
    private $namespace;
    /** @var int */
    private $all_values_set;

    private $questions;

    /**
     * @param string $destination_path
     */
    public function setDestinationPath($destination_path)
    {
        if (is_null($this->destination_path)) {
            $this->all_values_set++;
        }
        $this->destination_path = trim($destination_path);
        if ('/' != substr($this->destination_path, -1)) {
            $this->destination_path .= '/';
        }
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        if (is_null($this->host)) {
            $this->all_values_set++;
        }
        $this->host = trim($host);
    }

    /**
     * @param string $db_name
     */
    public function setDbName($db_name)
    {
        if (is_null($this->db_name)) {
            $this->all_values_set++;
        }
        $this->db_name = trim($db_name);
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        if (is_null($this->port)) {
            $this->all_values_set++;
        }
        $this->port = (int)trim($port);
    }

    /**
     * @param string $table_name
     */
    public function setTableName($table_name)
    {
        if (is_null($this->table_name)) {
            $this->all_values_set++;
        }
        $this->table_name = trim($table_name);
    }

    /**
     * @param string $user_name
     */
    public function setUserName($user_name)
    {
        if (is_null($this->user_name)) {
            $this->all_values_set++;
        }
        $this->user_name = trim($user_name);
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        if (is_null($this->password)) {
            $this->all_values_set++;
        }
        $this->password = trim($password);
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        if (is_null($this->author)) {
            $this->all_values_set++;
        }
        $this->author = trim($author);
    }

    /**
     * @param string $author
     */
    public function setNamespace($author)
    {
        if (is_null($this->namespace)) {
            $this->all_values_set++;
        }
        $this->namespace = trim($author);
    }


    /**
     * ModelMaker constructor
     */
    public function __construct()
    {
        $this->all_values_set = 0;
        $this->questions = [
            ['setDestinationPath', 'What is full path where model is saved?'],
            ['setHost', 'What is the server name the database is hosted?'],
            ['setDbName', 'What is the name of the database?'],
            ['setPort', 'What is the port number (it is usually 3306)?'],
            ['setTableName', 'What is the name of the table?'],
            ['setUserName', 'What is the user name?'],
            ['setPassword', 'What is the password?'],
            ['setNamespace', 'What is the name space?'],
            ['setAuthor', 'Who is the author of the model?'],
        ];
    }

    /**
     * @return array
     */
    public function getNextQuestion()
    {
        return $this->questions[$this->all_values_set];
    }

    /**
     * @throws Exception
     */
    public function create()
    {
        $db_conn = "mysql:host={$this->host};dbname={$this->db_name};port={$this->port};";
        $pdo = new PDO(
            $db_conn,
            $this->user_name,
            $this->password,
            [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            ]
        );
        $stmt = $pdo->query("Describe `{$this->db_name}`.`{$this->table_name}`;");
        if ($stmt instanceof PDOStatement) {
            $class_name = $this->getClassName();
            $model_template = file_get_contents('resources/model/model_template.leroy');
            $model_template = str_replace('$(author}', $this->author, $model_template);
            $model_template = str_replace('${date}', date('m/d/Y g:i A'), $model_template);
            $model_template = str_replace('${namespace}', $this->namespace, $model_template);
            $model_template = str_replace('${class_name}', $class_name, $model_template);
            $model_template = str_replace('${table_name}', $this->table_name, $model_template);
            $getter_setter_template = file_get_contents('resources/model/model_getter_setter.leroy');
            $getters_and_setters = '';
            $schema_template = file_get_contents('resources/model/model_schema_column.leroy');
            $schemas = '';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $method_name = $this->removeUnderscores($row['Field']);
                list($type, $length, $signed) = $this->getType($row['Type']);

                /* Set the Getters and Setters */
                $getter_and_setter = str_replace('${method_name}', $method_name, $getter_setter_template);
                $getter_and_setter = str_replace('${type}', $type, $getter_and_setter);
                $getter_and_setter = str_replace('${column}', $row['Field'], $getter_and_setter);
                $getters_and_setters .= $getter_and_setter;

                /* Set the schema array */
                $schema = str_replace('${column}', $row['Field'], $schema_template);
                $schema = str_replace('${type}', $type, $schema);
                $schema = str_replace('${length}', $length, $schema);
                $schema = str_replace('${signed}', $signed, $schema);
                $schemas .= $schema;

                /* Set the primary key */
                if ('PRI' == $row['Key']) {
                    $model_template = str_replace('${primary_key}', $row['Field'], $model_template);
                }
            }
            $model_template = str_replace('${getters_setters}', $getters_and_setters, $model_template);
            $model_template = str_replace('${schema}', $schemas, $model_template);
            $file_name = "{$this->destination_path}{$class_name}.php";
            if (file_exists($file_name)) {
                $time = time();
                $file_name = "{$this->destination_path}{$class_name}_{$time}.php";
            }
            file_put_contents($file_name, $model_template);
        } else {
            throw new Exception("There is no information for `{$this->db_name}`.`{$this->table_name}`");
        }
    }

    /**
     * @return bool
     */
    public function areAllValesSet()
    {
        echo __METHOD__ . ' $this->all_values_set: ' . print_r($this->all_values_set, true) . PHP_EOL;
        return count($this->questions) === $this->all_values_set;
    }

    /**
     * @param string $input
     * @return array [type, length, signed]
     */
    private function getType($input)
    {
        $length = 0;
        $signed = null;
        if (false !== strpos($input, '(')) {
            $input = str_replace(['(', ')'], ' ', $input);
        }
        if (false === strpos($input, ' ')) {
            $mysql_type = $input;
        } else {
            $parts = explode(' ', $input);
            if (3 === count($parts)) {
                list($mysql_type, $length, $signed) = $parts;
                $signed = ('signed' == $signed) ? 'true' : 'false';
            } else {
                list($mysql_type, $length) = $parts;
            }
        }
        switch ($mysql_type) {
            case 'char':
            case 'varchar':
                $type = 'string';
                break;
            case 'int':
                $type = 'integer';
                break;
            case 'decimal':
            case 'double':
                $type = 'float';
                break;
            case 'datetime':
            case 'timestamp':
                $type = 'DateTime|string';
                break;
            default:
                throw new InvalidArgumentException("'{$mysql_type}' is not a recognized type");
        }
        return [$type, $length, $signed];
    }

    /**
     * @return string
     */
    private function getClassName()
    {
        return "{$this->removeUnderscores($this->table_name)}Model";
    }

    /**
     * @param string $input
     * @return string
     */
    private function removeUnderscores($input)
    {
        $output = ucfirst($input);
        if (false !== strpos($output, '_')) {
            $parts = explode('_', $output);
            foreach ($parts as $i => $part) {
                $parts[$i] = ucfirst($part);
            }
            $output = implode('', $parts);
        }
        return $output;
    }
}
