<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 1/6/2019
 * Time: 7:12 AM
 *
 * @schema $_SESSION [
 *      guest => [
 *              skin_id => int
 *          ],
 *      auth => [
 *              token => string,
 *              prefix => string
 *          ],
 *      data => [
 *              __CLASS__ => [],
 *              __CLASS__ => [],..
 *          ],
 * ]
 * */

namespace Leroy\LeCache;

use Exception;
use InvalidArgumentException;

/**
 * Class SessionModel
 * @package PharmPay
 */
class LeSessionModel
{
    /* Session key names */
    const AUTH = 'auth';
    const GUEST = 'guest';
    const DATA = 'data';
    const AUTH_TOKEN = 'auth_token';
    const AUTH_SESSIONEXPIRES = 'session_expires';
    const AUTH_SESSIONLENGTH = 'session_timeout';
    const GUEST_SKINID = 'skin_id';

    /**
     * @return LeSessionModel
     */
    public static function init()
    {
        return new LeSessionModel();
    }

    //<editor-fold desc="Data Functions">
    /**
     * @param string $message
     */
    public function setError($message)
    {
        $this->initData();
        $_SESSION[self::DATA]['error'] = $message;
    }

    /**
     * @return string
     */
    public function getError()
    {
        if (!isset($_SESSION[self::DATA])) {
            $this->initData();
        }
        $output = $_SESSION[self::DATA]['error'];
        $_SESSION[self::DATA]['error'] = '';
        return $output;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->initData();
        $_SESSION[self::DATA]['message'] = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        if (!isset($_SESSION[self::DATA])) {
            $this->initData();
        }
        $output = $_SESSION[self::DATA]['message'];
        $_SESSION[self::DATA]['message'] = '';
        return $output;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param bool $class_specific
     */
    public function add($key, $value, $class_specific = true)
    {
        $this->initData();
        if ($class_specific) {
            $data_key = $this->getKeyForClassStorage();
            if (!isset($_SESSION[self::DATA][$data_key])) {
                $_SESSION[self::DATA][$data_key] = [];
            }
            if (isset($_SESSION[self::DATA][$data_key][$key])) {
                $_SESSION[self::DATA][$data_key][$key] = $this->addArray(
                    $_SESSION[self::DATA][$data_key][$key],
                    $value
                );
            } else {
                $_SESSION[self::DATA][$data_key][$key] = $value;
            }
        } else {
            if (isset($_SESSION[self::DATA][$key])) {
                $_SESSION[self::DATA][$key] = $this->addArray($_SESSION[self::DATA][$key], $value);
            } else {
                $_SESSION[self::DATA][$key] = $value;
            }
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param bool $class_specific
     */
    public function replace($key, $value, $class_specific = true)
    {
        if ($class_specific) {
            $data_key = $this->getKeyForClassStorage();
            if (!isset($_SESSION[self::DATA][$data_key])) {
                $_SESSION[self::DATA][$data_key] = [];
            }
            $_SESSION[self::DATA][$data_key][$key] = $value;
        } else {
            $_SESSION[self::DATA][$key] = $value;
        }
    }

    /**
     * @param string $key
     * @param bool $class_specific
     * @return array|false|mixed
     */
    public function get($key = '', $class_specific = true)
    {
        $output = false;
        if ($class_specific) {
            $data_key = $this->getKeyForClassStorage();
            if (!empty($key)) {
                if (isset($_SESSION[self::DATA][$data_key][$key])) {
                    $output = $_SESSION[self::DATA][$data_key][$key];
                }
            } elseif (isset($_SESSION[self::DATA][$data_key])) {
                $output = $_SESSION[self::DATA][$data_key];
            }
        } else {
            if (!empty($key)) {
                if (isset($_SESSION[self::DATA][$key])) {
                    $output = $_SESSION[self::DATA][$key];
                }
            } else {
                $output = $_SESSION[self::DATA];
            }
        }
        return $output;
    }

    /**
     * @param string $key
     * @param bool $class_specific
     */
    public function clear($key = '', $class_specific = true)
    {
        $data_key = $this->getKeyForClassStorage();
        if ($class_specific) {
            if (!empty($key)) {
                if (isset($_SESSION[self::DATA][$data_key][$key])) {
                    $_SESSION[self::DATA][$data_key][$key] = null;
                }
            } elseif (isset($_SESSION[self::DATA][$data_key])) {
                $_SESSION[self::DATA][$data_key] = null;
            }
        } else {
            if (!empty($key)) {
                if (isset($_SESSION[self::DATA][$key])) {
                    $_SESSION[self::DATA][$key] = null;
                }
            } else {
                $_SESSION[self::DATA] = null;
            }
        }
    }

    /**
     * @return string
     */
    private function getKeyForClassStorage()
    {
        $output = get_called_class();
        $trace = debug_backtrace();
        if (isset($trace[2])) {
            $output = $trace[2]['class'];
        }
        return $output;
    }

    /**
     * @param mixed $stored_value
     * @param mixed $value
     * @return array
     */
    private function addArray($stored_value, $value)
    {
        if (is_array($stored_value) && is_array($value)) {
            $output = array_merge($stored_value, $value);
        } elseif (is_array($stored_value)) {
            $output[] = $value;
        } elseif (is_array($value)) {
            $output = array_merge([$stored_value], $value);
        } else {
            $output = $value;
        }
        return $output;
    }

    private function initData()
    {
        $this->enforcePristineSchema();
        if (!isset($_SESSION[self::DATA])) {
            $_SESSION[self::DATA] = ['message' => '', 'error' => ''];
        }
    }
    //</editor-fold>

    //<editor-fold desc="Authentication Functions">
    public function destroyAuthenticatedSession()
    {
        /* All but the message in $_SESSION['data'] needs to be removed. */
        $message = $this->getMessage();
        $error = $this->getError();
        unset($_SESSION[self::DATA]);
        unset($_SESSION[self::AUTH]);
        if ($message) {
            $this->setMessage($message);
        }
        if ($error) {
            $this->setError($error);
        }
    }

    /**
     * @param array $input
     */
    public function setAuthValues(array $input)
    {
        /* First verify that all the keys are passed in */
        $required_keys = [self::AUTH_TOKEN, self::AUTH_SESSIONLENGTH,];
        foreach ($required_keys as $key) {
            if (!isset($input[$key])) {
                throw new InvalidArgumentException("{$key} is not set or empty");
            }
        }
        /* Then init the auth portion of the session. This will set the session expire to the default 30 minutes. */
        $this->initAuth();
        foreach ($required_keys as $key) {
            $_SESSION[self::AUTH][$key] = $input[$key];
        }
        /* Once the session length value is set, we can advance the expiration... Yes, this would happen
            at the next page load, but I want it here so in the future we can see the session length being used. */
        $this->advanceSessionTimeout();
    }

    /**
     * @return bool|string
     */
    public function getAuthToken()
    {
        $output = false;
        if (isset($_SESSION[self::AUTH][self::AUTH_TOKEN])) {
            $output = $_SESSION[self::AUTH][self::AUTH_TOKEN];
        }
        return $output;
    }

    /**
     * @return bool
     */
    public function getAccountPrefix()
    {
        $output = false;
        if (isset($_SESSION[self::AUTH][self::AUTH_TOKEN])) {
            $output = $_SESSION[self::AUTH][self::AUTH_TOKEN];
        }
        return $output;
    }

    /**
     * @return int
     */
    public function getSessionExpire()
    {
        /* Get a time that should be older then the value from the session */
        $output = time() - (86400 * 365); // a year ago to expire the session
        if (isset($_SESSION[self::AUTH][self::AUTH_SESSIONEXPIRES])) {
            $output = $_SESSION[self::AUTH][self::AUTH_SESSIONEXPIRES];
        }
        return $output;
    }

    /**
     * @return bool
     */
    public function hasSessionExpired()
    {
        return (time() >= $this->getSessionExpire());
    }

    /**
     * @param string $interval
     * @return int Default 1800 seconds (30 minutes)
     */
    public function getSessionLength($interval = 'seconds')
    {
        $output = 1800; // 30 minutes
        if (isset($_SESSION[self::AUTH][self::AUTH_SESSIONLENGTH])) {
            $output = $_SESSION[self::AUTH][self::AUTH_SESSIONLENGTH];
        }
        if ('minutes' == $interval) {
            $output = (int)round($output/60, 0);
        }
        return $output;
    }

    public function advanceSessionTimeout()
    {
        if (!$this->getAuthToken()) {
            throw new Exception('Attempt to advance session timeout without an authenticated session');
        }
        $_SESSION[self::AUTH][self::AUTH_SESSIONEXPIRES] = time() + $this->getSessionLength();
    }

    private function initAuth()
    {
        $this->enforcePristineSchema();
        if (!isset($_SESSION[self::AUTH])) {
            $_SESSION[self::AUTH] = [
                self::AUTH_TOKEN => '',
                self::AUTH_SESSIONEXPIRES => time() + $this->getSessionLength(),
                self::AUTH_SESSIONLENGTH => '',
            ];
        }
    }
    //</editor-fold>

    //<editor-fold desc="Guest Functions">
    /**
     * @return bool
     */
    public function getSkinId()
    {
        $output = false;
        if (isset($_SESSION[self::GUEST][self::GUEST_SKINID])) {
            $output = $_SESSION[self::GUEST][self::GUEST_SKINID];
        }
        return $output;
    }

    /**
     * @param int $value
     * @return LeSessionModel Returning the object in case there are more items to set;
     */
    public function setSkinId($value)
    {
        $session = new LeSessionModel();
        $session->initGuest();
        $_SESSION[self::GUEST][self::GUEST_SKINID] = $value;
    }

    private function initGuest()
    {
        $this->enforcePristineSchema();
        if (!isset($_SESSION[self::GUEST])) {
            $_SESSION[self::GUEST] = [self::GUEST_SKINID => 0,];
        }
    }
    //</editor-fold>

    /**
     * @Note: To ensure the _SESSION doesn't become overloaded with a bunch of random keys,
     *          we want to enforce code to use this system. Every time a set is done, it runs
     *          the associated init function, which in turn runs this function. So, every
     *          set*() call will clean out the _SESSION.
     */
    private function enforcePristineSchema()
    {
        $keys = array_keys($_SESSION);
        foreach ($keys as $key) {
            if (!in_array($key, [self::AUTH, self::GUEST, self::DATA])) {
                unset($_SESSION[$key]);
            }
        }
    }
}
