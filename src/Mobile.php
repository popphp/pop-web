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
 * Mobile class
 *
 * @category   Pop
 * @package    Pop_Web
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    2.0.0
 */
class Mobile
{

    /**
     * Constant to route desktop display
     * @var int
     */
    const DESKTOP = 'DESKTOP';

    /**
     * Constant to route tablet display
     * @var int
     */
    const TABLET = 'TABLET';

    /**
     * Constant to route mobile display
     * @var int
     */
    const MOBILE = 'MOBILE';

    /**
     * User agent property
     * @var string
     */
    protected $ua = null;

    /**
     * Mobile Device
     * @var string
     */
    protected $device = null;

    /**
     * Desktop website destination URL
     * @var string
     */
    protected $desktopUrl = null;

    /**
     * Mobile website destination URL
     * @var string
     */
    protected $tabletUrl = null;

    /**
     * Mobile website destination URL
     * @var string
     */
    protected $mobileUrl = null;

    /**
     * Route flag
     * @var string
     */
    protected $route = null;

    /**
     * Desktop detect flag
     * @var boolean
     */
    protected $desktop = false;

    /**
     * Tablet detect flag
     * @var boolean
     */
    protected $tablet = false;

    /**
     * Mobile detect flag
     * @var boolean
     */
    protected $mobile = false;

    /**
     * Android flag
     * @var boolean
     */
    protected $android = false;

    /**
     * Apple flag
     * @var boolean
     */
    protected $apple = false;

    /**
     * Windows flag
     * @var boolean
     */
    protected $windows = false;

    /**
     * Blackberry flag
     * @var boolean
     */
    protected $blackberry = false;

    /**
     * Pre flag
     * @var boolean
     */
    protected $pre = false;

    /**
     * Opera flag
     * @var boolean
     */
    protected $opera = false;

    /**
     * Constructor
     *
     * Instantiate the mobile object
     *
     * @param  array $options
     * @return Mobile
     */
    public function __construct(array $options = [])
    {
        // Set the user agent and object properties.
        $this->ua = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : null;

        if (isset($options['desktop'])) {
            $this->desktopUrl = $options['desktop'];
        }
        if (isset($options['tablet'])) {
            $this->tabletUrl = $options['tablet'];
        }
        if (isset($options['mobile'])) {
            $this->mobileUrl = $options['mobile'];
        }
        if (isset($options['route'])) {
            $this->route = $options['route'];
        }

        $this->detect();
    }

    /**
     * Static method to only detect a desktop device or not
     *
     * @return boolean
     */
    public static function isDesktopDevice()
    {
        return (new static())->isDesktop();
    }

    /**
     * Static method to only detect a tablet device or not
     *
     * @return boolean
     */
    public static function isTabletDevice()
    {
        return (new static())->isTablet();
    }

    /**
     * Static method to only detect a mobile device or not
     *
     * @return boolean
     */
    public static function isMobileDevice()
    {
        return (new static())->isMobile();
    }

    /**
     * Static method to only get the mobile device
     *
     * @return string
     */
    public static function getDevice()
    {
        return (new static())->getDeviceName();
    }

    /**
     * Get user-agent
     *
     * @return string
     */
    public function getUa()
    {
        return $this->ua;
    }

    /**
     * Get device name
     *
     * @return string
     */
    public function getDeviceName()
    {
        return $this->device;
    }

    /**
     * Get desktop URL
     *
     * @return string
     */
    public function getDesktopUrl()
    {
        return $this->desktopUrl;
    }

    /**
     * Get tablet URL
     *
     * @return string
     */
    public function getTabletUrl()
    {
        return $this->tabletUrl;
    }

    /**
     * Get mobile URL
     *
     * @return string
     */
    public function getMobileUrl()
    {
        return $this->mobileUrl;
    }

    /**
     * Get route flag
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set desktop URL
     *
     * @param string $url
     * @return Mobile
     */
    public function setDesktopUrl($url)
    {
        $this->desktopUrl = $url;
        return $this;
    }

    /**
     * Set tablet URL
     *
     * @param string $url
     * @return Mobile
     */
    public function setTabletUrl($url)
    {
        $this->tabletUrl = $url;
        return $this;
    }

    /**
     * Set mobile URL
     *
     * @param string $url
     * @return Mobile
     */
    public function setMobileUrl($url)
    {
        $this->mobileUrl = $url;
        return $this;
    }

    /**
     * Set route flag
     *
     * @param string $route
     * @return Mobile
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * Set is desktop flag
     *
     * @return boolean
     */
    public function isDesktop()
    {
        return $this->desktop;
    }

    /**
     * Get is tablet flag
     *
     * @return boolean
     */
    public function isTablet()
    {
        return $this->tablet;
    }

    /**
     * Get is mobile flag
     *
     * @return boolean
     */
    public function isMobile()
    {
        return $this->mobile;
    }

    /**
     * Get Android flag
     *
     * @return boolean
     */
    public function isAndroid()
    {
        return $this->android;
    }

    /**
     * Get Apple flag
     *
     * @return boolean
     */
    public function isApple()
    {
        return $this->apple;
    }

    /**
     * Get Windows flag
     *
     * @return boolean
     */
    public function isWindows()
    {
        return $this->windows;
    }

    /**
     * Get Blackberry flag
     *
     * @return boolean
     */
    public function isBlackberry()
    {
        return $this->blackberry;
    }

    /**
     * Get Pre flag
     *
     * @return boolean
     */
    public function isPre()
    {
        return $this->pre;
    }

    /**
     * Get Opera flag
     *
     * @return boolean
     */
    public function isOpera()
    {
        return $this->opera;
    }

    /**
     * Go to the desktop site
     *
     * @throws Exception
     * @return void
     */
    public function goToDesktop()
    {
        if (null === $this->desktopUrl) {
            throw new Exception('The desktop site is not set.');
        }
        header('HTTP/1.1 302 Found');
        header('Location: ' . $this->desktopUrl);
    }

    /**
     * Go to the tablet site
     *
     * @throws Exception
     * @return void
     */
    public function goToTablet()
    {
        if (null === $this->tabletUrl) {
            throw new Exception('The tablet site is not set.');
        }
        header('HTTP/1.1 302 Found');
        header('Location: ' . $this->tabletUrl);
    }

    /**
     * Go to the mobile site
     *
     * @throws Exception
     * @return void
     */
    public function goToMobile()
    {
        if (null === $this->mobileUrl) {
            throw new Exception('The mobile site is not set.');
        }
        header('HTTP/1.1 302 Found');
        header('Location: ' . $this->mobileUrl);
    }

    /**
     * Go to a specific URL
     *
     * @param  string $url
     * @return void
     */
    public function goToURL($url)
    {
        header('HTTP/1.1 302 Found');
        header('Location: ' . $url);
    }

    /**
     * Route to the appropriate URL
     *
     * @return void
     */
    public function route()
    {
        switch ($this->route) {
            case self::DESKTOP:
                $this->goToDesktop();
                break;

            case self::TABLET:
                $this->goToTablet();
                break;

            case self::MOBILE:
                $this->goToMobile();
                break;

            default:
                if ($this->desktop) {
                    $this->goToDesktop();
                } else if ($this->tablet) {
                    $this->goToTablet();
                } else if ($this->mobile) {
                    $this->goToMobile();
                }
        }
    }

    /**
     * Detect whether or not the device is a mobile device or not
     *
     * @return void
     */
    protected function detect()
    {
        $matches = [];

        // Android devices
        if (stripos($this->ua, 'android') !== false) {
            $this->device = 'Android';
            $this->android = true;
            $this->mobile = true;
        // Blackberry devices
        } else if (stripos($this->ua, 'blackberry') !== false) {
            $this->device = 'Blackberry';
            $this->blackberry = true;
            $this->mobile = true;
        // Windows devices
        } else if ((stripos($this->ua, 'windows ce') !== false) || (stripos($this->ua, 'windows phone') !== false)) {
            $this->device = 'Windows';
            $this->windows = true;
            $this->mobile = true;
        // Opera devices
        } else if (stripos($this->ua, 'opera mini') !== false) {
            $this->device = 'Opera';
            $this->opera = true;
            $this->mobile = true;
        // Palm Pre devices
        } else if ((stripos($this->ua, 'pre') !== false) && (stripos($this->ua, 'presto') === false)) {
            $this->device = 'Pre';
            $this->pre = true;
            $this->mobile = true;
        // Apple devices
        } else if (preg_match('/(ipod|iphone|ipad)/i', $this->ua, $matches) != 0) {
            $this->device = $matches[0];
            $this->apple = true;
            $this->mobile = true;
        // Other devices
        } else if (preg_match('/(nokia|symbian|palm|treo|hiptop|avantgo|plucker|xiino|blazer|elaine|teleca|up.browser|up.link|mmp|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|pda|psp)/i', $this->ua, $matches) != 0) {
            $this->device = $matches[0];
            $this->mobile = true;
        }

        if ($this->mobile) {
            if (strtolower($this->device) == 'ipad') {
                $this->tablet = true;
                $this->mobile = false;
            } else if (stripos($this->ua, 'mobile') === false) {
                $this->tablet = true;
                $this->mobile = false;
            }
        } else {
            $this->desktop = true;
        }
    }

}
