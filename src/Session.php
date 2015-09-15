<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Web;

/**
 * Session class
 *
 * @category   Pop
 * @package    Pop_Web
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    2.0.1
 */
class Session implements \ArrayAccess
{

    /**
     * Instance of the session
     * @var object
     */
    private static $instance = null;

    /**
     * Session ID
     * @var string
     */
    private $sessionId = null;

    /**
     * Constructor
     *
     * Private method to instantiate the session object
     *
     * @return Session
     */
    private function __construct()
    {
        // Start a session and set the session id.
        if (session_id() == '') {
            session_start();
            $this->sessionId = session_id();
            $this->init();
        }
    }

    /**
     * Determine whether or not an instance of the session object exists already,
     * and instantiate the object if it does not exist.
     *
     * @return Session
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Session();
        }

        return self::$instance;
    }

    /**
     * Set a time-based value
     *
     * @param  string $key
     * @param  mixed  $value
     * @param  int    $expire
     * @return Session
     */
    public function setTimedValue($key, $value, $expire = 300)
    {
        $_SESSION[$key] = $value;
        $_SESSION['_POP']['expirations'][$key] = time() + (int)$expire;
        return $this;
    }

    /**
     * Set a request-based value
     *
     * @param  string $key
     * @param  mixed  $value
     * @param  int    $hops
     * @return Session
     */
    public function setRequestValue($key, $value, $hops = 1)
    {
        $_SESSION[$key] = $value;
        $_SESSION['_POP']['requests'][$key] = [
            'current' => 0,
            'limit'   => (int)$hops
        ];
        return $this;
    }

    /**
     * Return the current the session id
     *
     * @return string
     */
    public function getId()
    {
        return $this->sessionId;
    }

    /**
     * Regenerate the session id
     *
     * @return void
     */
    public function regenerateId()
    {
        session_regenerate_id();
        $this->sessionId = session_id();
    }

    /**
     * Destroy the session
     *
     * @return void
     */
    public function kill()
    {
        $_SESSION = null;
        session_unset();
        session_destroy();
        unset($this->sessionId);
    }

    /**
     * Init the session
     *
     * @return void
     */
    private function init()
    {
        if (!isset($_SESSION['_POP'])) {
            $_SESSION['_POP'] = [
                'requests'    => [],
                'expirations' => []
            ];
        } else if (isset($_SESSION['_POP']) && !isset($_SESSION['_POP']['requests'])) {
            $_SESSION['_POP']['requests']    = [];
            $_SESSION['_POP']['expirations'] = [];
        } else {
            $this->checkRequests();
            $this->checkExpirations();
        }
    }

    /**
     * Check the request-based session values
     *
     * @return void
     */
    private function checkRequests()
    {
        foreach ($_SESSION as $key => $value) {
            if (isset($_SESSION['_POP']['requests'][$key])) {
                $_SESSION['_POP']['requests'][$key]['current']++;
                if ($_SESSION['_POP']['requests'][$key]['current'] > $_SESSION['_POP']['requests'][$key]['limit']) {
                    unset($_SESSION[$key]);
                    unset($_SESSION['_POP']['requests'][$key]);
                }
            }
        }
    }

    /**
     * Check the time-based session values
     *
     * @return void
     */
    private function checkExpirations()
    {
        foreach ($_SESSION as $key => $value) {
            if (isset($_SESSION['_POP']['expirations'][$key]) && (time() > $_SESSION['_POP']['expirations'][$key])) {
                unset($_SESSION[$key]);
                unset($_SESSION['_POP']['expirations'][$key]);
            }
        }
    }

    /**
     * Set a property in the session object that is linked to the $_SESSION global variable
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Get method to return the value of the $_SESSION global variable
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (isset($_SESSION[$name])) ? $_SESSION[$name] : null;
    }

    /**
     * Return the isset value of the $_SESSION global variable
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }

    /**
     * Unset the $_SESSION global variable
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        $_SESSION[$name] = null;
        unset($_SESSION[$name]);
    }

    /**
     * ArrayAccess offsetSet
     *
     * @param  mixed $offset
     * @param  mixed $value
     * @throws Exception
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }

    /**
     * ArrayAccess offsetGet
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    /**
     * ArrayAccess offsetExists
     *
     * @param  mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    /**
     * ArrayAccess offsetUnset
     *
     * @param  mixed $offset
     * @throws Exception
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }

}
