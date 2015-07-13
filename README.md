pop-web
=======

OVERVIEW
--------
`pop-web` is collection of web-based tools that can be utilized by a web-based application.
It contains core features that help to use, parse and manipulate sessions, cookies, mobile devices,
browser data and server data.

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

### Using cookies

```php
use Pop\Web\Cookie;

$cookie = Cookie::getInstance([
    'path'  => '/',
    'expire => time() + 3600
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

