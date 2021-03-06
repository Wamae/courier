<?php

define('LARAVEL_START', microtime(true));
define('ACTIVE', 1);
define('INACTIVE', 0);

/*Manifest status*/
define('DISPATCHED', 2);
define('CANCELLED', 3);
define('OFFLOADED', 4);

/*Waybill status*/
define('LOADED', 2);
define('DELIVERED', 3);

/*Currencies*/
define('KSH', 1);

/*Payment modes*/
define('CASH_ON_DELIVERY', 2);
define('CASH_PAYMENT', 3);
define('ACCOUNT_PAYMENT', 4);
define('FREE_OF_CHARGE', 5);

/*Ajax responses*/
define('OK',1);
define('FAILED',FALSE);

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
