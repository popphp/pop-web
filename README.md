pop-web
=======

OVERVIEW
--------
`pop-web` is collection of web-based tools that can be utilized by a web-based application.
It contains core features that help to use, parse and manipulate sessions, cookies, mobile
devices and browser and server data.

`pop-web` is a component of the [Pop PHP Framework](http://www.popphp.org/).

INSTALL
-------

Install `pop-web` using Composer.

    composer require popphp/pop-web

BASIC USAGE
-----------

### Using sessions

```php
use Pop\Web\Session;

$sess = Session::getInstance();

// Set session values
$sess->foo   = 'bar';
$sess['baz'] = 123;

// Access session values
echo $sess['foo'];
echo $sess->baz;

// Unset session values
unset($sess->foo);
unset($sess['baz']);

// Kill/clear out the session
$sess->kill();
```

### Advanced sessions

##### Session values available based on time expiration:

```php
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->setTimedValue('foo', 'bar', 10); // # of seconds

if (isset($sess->foo)) {
    echo $sess->foo;
} else {
    echo 'Nope!';
}
```

##### Session values available based on number of requests:

```php
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->setRequestValue('foo', 'bar', 1); // # of requests

if (isset($sess->foo)) {
    echo $sess->foo;
} else {
    echo 'Nope!';
}
```

##### Session values available based on number of namespace:

```php
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->setNamespaceValue('foo', 'bar', __NAMESPACE__);

if (isset($sess->foo)) {
    echo $sess->foo;
} else {
    echo 'Nope!';
}
```

### Using cookies

```php
use Pop\Web\Cookie;

$cookie = Cookie::getInstance([
    'path'   => '/',
    'expire' => time() + 3600
]);

// Set cookie values
$cookie->foo = 'bar';
$cookie['baz'] = 123;

// Access cookie values
echo $cookie->foo;
echo $cookie['baz'];

// Unset cookie values
unset($cookie->foo);
unset($cookie['baz']);
```

### Accessing server data

```php
$server = new Pop\Web\Server();

// Linux
echo $server->getOs();

// Ubuntu
echo $server->getDistro();

// Apache
echo $server->getServer();

// 2.4
echo $server->getServerVersion();
```

### Accessing browser data

```php
$browser = new Pop\Web\Browser();

// Firefox
echo $browser->getName();

// 39.0
echo $browser->getVersion();

// Linux
echo $browser->getPlatform();

// Returns false
if ($browser->isMsie()) {}
```

### Managing mobile requests and redirection

##### Auto-detect and route

```php
$mobile = new Pop\Web\Mobile([
    'desktop' => 'http://www.mydomain.com/',
    'tablet'  => 'http://tablet.mydomain.com/',
    'mobile'  => 'http://mobile.mydomain.com/'
]);

$mobile->route();
```

##### Force redirect route

```php
$mobile = new Pop\Web\Mobile([
    'desktop' => 'http://www.mydomain.com/',
    'tablet'  => 'http://tablet.mydomain.com/',
    'mobile'  => 'http://mobile.mydomain.com/'
]);

// If an iPad, force redirect
if ($mobile->isApple() && $mobile->isTablet()) {
    $mobile->setRoute(Pop\Web\Mobile::TABLET);
}

$mobile->route();
```
