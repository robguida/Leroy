<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/23/2018
 * Time: 11:28 AM
 */

namespace Leroy\LeCli;

/**
 * Class LePrompter
 * @package Leroy\LeCli
 *
 * @Note See LeroyConsole\LeMVCS\ModelMaker for an example on using LePrompter
 */
abstract class LePrompterAbstract
{
    /** @var int */
    private $all_values_set;
    /**
     * @var array
     * @example [
     *              questions => string - question to prompt for the end-user,
     *              setter => string - function to call to set value,
     *              callback => string - function to call to test sets of values
     *              hide_entry => boolean - to hide the end-users keystrokes for the questions i.e.: password
     *          ]
     */
    private $questions;
    /** @var resource */
    private $stdin_stream;

    /**
     * LePrompter constructor.
     * @param array $options
     */
    public function __construct(array $options = null)
    {
        $this->all_values_set = 0;
        $this->questions = (isset($options['questions'])) ? $options['questions'] : [];
        $this->stdin_stream = fopen("php://stdin", "r");
    }

    public function __destruct()
    {
        fclose($this->stdin_stream);
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
            /* If there is a callback, then run it. If it fails, like the setter, it
                returns an error questions. This gets asked immediately, and the
                end-user continues with the questioning. Note: the callbacks, when they fail
                should reset the values that caused the error, and have the end-user start
                from that point again. */
            if (!empty($callback) && $error_question = $this->$callback()) {
                echo $error_question;
            }
            $setter = $question = null;
        }
    }

    /**
     * @param int $input
     */
    protected function incrementStep($input = 1)
    {
        $this->all_values_set += $input;
    }

    /**
     * @param int $input
     */
    protected function decrementStep($input = 1)
    {
        $this->all_values_set -= $input;
    }

    /**
     * @return array
     */
    protected function getNextQuestion()
    {
        return array_values($this->questions[$this->all_values_set]);
    }

    /**
     * @return bool
     */
    protected function areAllValesSet()
    {
        return count($this->questions) === $this->all_values_set;
    }
}