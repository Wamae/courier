<?php

define('LARAVEL_START', microtime(true));
define('ACTIVE', 1);
define('INACTIVE', 0);

/*Manifest status*/
define('DISPATCHED', 2);
define('CENCELLED', 3);

/*Waybill status*/
define('LOADED', 2);

/*Currencies*/
define('KSH', 1);
/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so we do not have to manually load any of
| our application's PHP classes. It just feels great to relax.
|
*/

require_once __DIR__.'/../vendor/autoload.php';
