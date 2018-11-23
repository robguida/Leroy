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
    /** @var string */
    private $directory;
    /** @var array */
    private $questions;
    /** @var resource */
    private $stdin_stream;
    /** @var PDO */
    private $pdo;
    /** @var PDOStatement */
    private $stmt;

    //<editor-fold desc="Getters/Setters">
    /**
     * @param string $destination_path
     * @return string
     */
    public function setDestinationPath($destination_path)
    {
        $output = '';
        $destination_path = trim($destination_path);
        if (file_exists($destination_path)) {
            if (is_null($this->destination_path)) {
                $this->all_values_set++;
            }
            $this->destination_path = $destination_path;
            if ('/' != substr($this->destination_path, -1)) {
                $this->destination_path .= '/';
            }
        } elseif (mkdir($destination_path, 0777, true)) {
            $this->setDestinationPath($destination_path);
        } else {
            $output = "This path, \"{$destination_path}\" does not exist, and the attempt to create it failed. " .
                "ModelMaker must have write permissions to the directory. " .
                "Re-enter the path where the model is to be saved.\t";
        }
        return $output;
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
    //</editor-fold>

    /**
     * ModelMaker constructor
     * @param $dir
     */
    public function __construct($dir)
    {
        if ('/' != substr($dir, -1)) {
            $dir .= '/';
        }
        $this->directory = $dir;
        $this->all_values_set = 0;
        $this->questions = [
            ['callback' => '', 'setter' => 'setDestinationPath', 'question' => 'What is full path to save the model?'],
            ['callback' => '', 'setter' => 'setHost', 'question' => 'What is the server name?'],
            ['callback' => '', 'setter' => 'setPort', 'question' => 'What is the port number (it is usually 3306)?'],
            ['callback' => '', 'setter' => 'setDbName', 'question' => 'What is the name of the database?'],
            ['callback' => '', 'setter' => 'setUserName', 'question' => 'What is the user name?'],
            ['callback' => 'setPdo', 'setter' => 'setPassword', 'question' => 'What is the password?'],
            ['callback' => 'setStmt', 'setter' => 'setTableName', 'question' => 'What is the name of the table?'],
            ['callback' => '', 'setter' => 'setNamespace', 'question' => 'What is the name space?'],
            ['callback' => '', 'setter' => 'setAuthor', 'question' => 'Who is the author of the model?'],
        ];
        $this->stdin_stream = fopen("php://stdin", "r");
    }

    public function __destruct()
    {
        fclose($this->stdin_stream);
    }

    /**
     * @param string|null $setter
     * @param string|null $question
     */
    public function gatherData($setter = null, $question = null)
    {
        while (!$this->areAllValesSet()) {
            if (is_null($setter) || is_null($question)) {
                list($callback, $setter, $question) = $this->getNextQuestion();
            }
            echo "{$question}\t";
            $value = fgets($this->stdin_stream);
            /* If the setter returns a question, that means there was an error,
                and the error_question needs to be satisfied before moving forward. */
            if ($error_question = $this->$setter($value)) {
                $this->gatherData($setter, $error_question);
            }
            if (!empty($callback) && $error_question = $this->$callback()) {
               echo $error_question;
            }
            $setter = $question = null;
        }
    }

    /**
     * @return array
     */
    public function getNextQuestion()
    {
        return array_values($this->questions[$this->all_values_set]);
    }

    /**
     * @return bool|string
     * @throws Exception
     */
    public function create()
    {
        if ($this->stmt instanceof PDOStatement) {
            $class_name = $this->getClassName();
            $model_template = file_get_contents("{$this->directory}resources/model/model_template.leroy");
            $getter_setter_template = file_get_contents("{$this->directory}resources/model/model_getter_setter.leroy");
            $schema_template = file_get_contents("{$this->directory}resources/model/model_schema_column.leroy");

            $getters_and_setters = '';
            $schemas = '';
            $uses = '';

            $model_template = str_replace('$(author}', $this->author, $model_template);
            $model_template = str_replace('${date}', date('m/d/Y g:i A'), $model_template);
            $model_template = str_replace('${namespace}', $this->namespace, $model_template);
            $model_template = str_replace('${class_name}', $class_name, $model_template);
            $model_template = str_replace('${table_name}', $this->table_name, $model_template);

            while ($row = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                $method_name = $this->removeUnderscores($row['Field']);
                list($type, $length, $signed) = $this->getType($row['Type']);
                $type_for_schema = $type;

                /* add a use when the type is DateTime */
                if (0 === strpos($type, 'DateTime')) {
                    if (false === strpos($uses, 'DateTime')) {
                        $uses .= 'use DateTime;' . PHP_EOL;
                    }
                    $type_for_schema = 'DateTime';
                }
                /* if length is an array, then make it a string for replacing the placeholder */
                if (is_array($length)) {
                    $length = '[' . implode(', ', $length) . ']';
                }

                /* Set the Getters and Setters */
                $getter_and_setter = str_replace('${method_name}', $method_name, $getter_setter_template);
                $getter_and_setter = str_replace('${type}', $type, $getter_and_setter);
                $getter_and_setter = str_replace('${column}', $row['Field'], $getter_and_setter);
                $getters_and_setters .= $getter_and_setter;

                /* Set the schema array */
                $schema = str_replace('${column}', $row['Field'], $schema_template);
                $schema = str_replace('${type}', $type_for_schema, $schema);
                $schema = str_replace('${signed}', $signed, $schema);
                $schema = str_replace('${length}', $length, $schema);
                $schemas .= $schema;

                /* Set the primary key */
                if ('PRI' == $row['Key']) {
                    $model_template = str_replace('${primary_key}', $row['Field'], $model_template);
                }
            }

            $model_template = str_replace('${getters_setters}', $getters_and_setters, $model_template);
            $model_template = str_replace('${schema}', $schemas, $model_template);
            $model_template = str_replace('${uses}', $uses, $model_template);
            $file_name = "{$this->destination_path}{$class_name}.php";
            if (file_exists($file_name)) {
                $time = time();
                $file_name = "{$this->destination_path}{$class_name}_{$time}.php";
            }
            $output = file_put_contents($file_name, $model_template);
            if ($output) {
                $output = $file_name;
            }
        } else {
            throw new Exception("There is no information for `{$this->db_name}`.`{$this->table_name}`");
        }
        return $output;
    }

    /**
     * @return bool
     */
    public function areAllValesSet()
    {
        return count($this->questions) === $this->all_values_set;
    }

    /**
     * @return string
     */
    protected function setPdo()
    {
        $output = '';
        try {
            $db_conn = "mysql:host={$this->host};dbname={$this->db_name};port={$this->port};";
            $this->pdo = new PDO(
                $db_conn,
                $this->user_name,
                $this->password,
                [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_FOUND_ROWS => true
                ]
            );
        } catch (Exception $e) {
            $this->host = null;
            $this->db_name = null;
            $this->port = null;
            $this->user_name = null;
            $this->password = null;
            $this->all_values_set -= 5;
            $output = "PDO failed with \"{$e->getMessage()}\". Check your credentials. Press enter to continue\n";
        }
        return $output;
    }

    /**
     * @return string
     */
    protected function setStmt()
    {
        $output = '';
        try {
            $this->stmt = $this->pdo->query("Describe `{$this->db_name}`.`{$this->table_name}`;");
        } catch (Exception $e) {
            $this->table_name = null;
            $this->all_values_set--;
            $output = "PDO:query() failed with \"{$e->getMessage()}\". Re-enter the table name, or create " .
                "it if it does not exist. Press enter to continue.\n";
        }
        return $output;
    }

    /**
     * @param string $input
     * @return array [type, length, signed]
     */
    protected function getType($input)
    {
        $length = 0;
        $signed = 'false';
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
            case 'enum':
                $length = [$length];
                $signed = 'false';
                // this intentionally falls through to the next case
            case 'char':
            case 'varchar':
            case 'binary':
            case 'text':
                 $type = 'string';
                break;
            case 'bigint':
            case 'medint':
            case 'smallint':
            case 'tinyint':
            case 'int':
                $type = 'integer';
                break;
            case 'decimal':
            case 'double':
                $length = [$length];
                $type = 'float';
                break;
            case 'datetime':
            case 'timestamp':
                $type = 'DateTime|string';
                break;
            default:
                throw new InvalidArgumentException("'{$mysql_type}' is not a recognized type");
        }
        $output = [$type, $length, $signed];
        return $output;
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        return "{$this->removeUnderscores($this->table_name)}Model";
    }

    /**
     * @param string $input
     * @return string
     */
    protected function removeUnderscores($input)
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
