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
 * @version    2.0.0
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
