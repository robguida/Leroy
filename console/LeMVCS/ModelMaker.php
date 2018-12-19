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
use Leroy\LeCli\LePrompterAbstract;
use PDO;
use PDOStatement;

class ModelMaker extends LePrompterAbstract
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
    /** @var string */
    private $directory;
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
                $this->incrementStep();
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
            $this->incrementStep();
        }
        $this->host = trim($host);
    }

    /**
     * @param string $db_name
     */
    public function setDbName($db_name)
    {
        if (is_null($this->db_name)) {
            $this->incrementStep();
        }
        $this->db_name = trim($db_name);
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        if (is_null($this->port)) {
            $this->incrementStep();
        }
        $this->port = (int)trim($port);
    }

    /**
     * @param string $table_name
     */
    public function setTableName($table_name)
    {
        if (is_null($this->table_name)) {
            $this->incrementStep();
        }
        $this->table_name = trim($table_name);
    }

    /**
     * @param string $user_name
     */
    public function setUserName($user_name)
    {
        if (is_null($this->user_name)) {
            $this->incrementStep();
        }
        $this->user_name = trim($user_name);
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        if (is_null($this->password)) {
            $this->incrementStep();
        }
        $this->password = trim($password);
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        if (is_null($this->author)) {
            $this->incrementStep();
        }
        $this->author = trim($author);
    }

    /**
     * @param string $author
     */
    public function setNamespace($author)
    {
        if (is_null($this->namespace)) {
            $this->incrementStep();
        }
        $this->namespace = trim($author);
    }
    //</editor-fold>

    /**
     * ModelMaker|LePrompter constructor.
     * @param array $options
     */
    public function __construct(array $options = null)
    {
        if (!isset($options['dir'])) {
            $options['dir'] = __DIR__;
        }
        if ('/' != substr($options['dir'], -1)) {
            $options['dir'] .= '/';
        }
        $this->directory = $options['dir'];
        unset($options['dir']);
        $options['questions'] = [
            [
                'hide_entry' => false,
                'callback' => '',
                'setter' => 'setDestinationPath',
                'question' => 'What is full path to save the model?'
            ],
            [
                'hide_entry' => false,
                'callback' => '',
                'setter' => 'setHost',
                'question' => 'What is the server name?'
            ],
            [
                'hide_entry' => false,
                'callback' => '',
                'setter' => 'setPort',
                'question' => 'What is the port number (it is usually 3306)?'
            ],
            [
                'hide_entry' => false,
                'callback' => '',
                'setter' => 'setDbName',
                'question' => 'What is the name of the database?'
            ],
            [
                'hide_entry' => false,
                'callback' => '',
                'setter' => 'setUserName',
                'question' => 'What is the user name?'
            ],
            [
                'hide_entry' => true,
                'callback' => 'setPdo',
                'setter' => 'setPassword',
                'question' => 'What is the password?'
            ],
            [
                'hide_entry' => false,
                'callback' => 'setStmt',
                'setter' => 'setTableName',
                'question' => 'What is the name of the table?'
            ],
            [
                'hide_entry' => false,
                'callback' => '',
                'setter' => 'setNamespace',
                'question' => 'What is the name space?'
            ],
            [
                'hide_entry' => false,
                'callback' => '',
                'setter' => 'setAuthor',
                'question' => 'Who is the author of the model?'
            ],
        ];
        parent::__construct($options);
    }

    /**
     * @param string|null $setter
     * @param string|null $question
     * Note: This function loops through the questions and prompts the end-user, and collects the information.
     *      It handles errors when attempting to store the data, so the end-user deals with each issue before
     *      moving onto the next question. Each question may also have a callback that can test the values
     *      of previous questions before moving onto another set of questions.
     *
     * @todo Break down into 2 functions, one that will recurse without the looping
     */
    public function gatherData($setter = null, $question = null)
    {
        parent::gatherData($setter, $question);
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

                /* Set the primary key */
                if ('PRI' == $row['Key']) {
                    $model_template = str_replace('${primary_key}', $row['Field'], $model_template);
                } else {
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
            $this->decrementStep(5);
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
            $this->decrementStep();
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
                $type = 'enum';
                break;
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
