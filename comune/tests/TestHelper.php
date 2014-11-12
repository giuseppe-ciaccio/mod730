<?php
/*
 * Start output buffering
 */
ob_start();

/*
 * Set error reporting to the level to which code must comply.
 */
error_reporting(E_ALL | E_STRICT);

/*
 * Set default timezone
 */
date_default_timezone_set('GMT');

/*
 * Testing environment
 */
define('BASE_PATH', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR));
define('APPLICATION_PATH', BASE_PATH.DIRECTORY_SEPARATOR.'application');
define('APPLICATION_ENV', 'testing');

/*
 * Determine the root, library, tests, and models directories
 */
$library     = BASE_PATH.DIRECTORY_SEPARATOR.'library';
$tests       = BASE_PATH.DIRECTORY_SEPARATOR.'tests';
$models      = BASE_PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'models';
$controllers = BASE_PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'controllers';

/* to include the libraries used only by unit tests */
$library_test = BASE_PATH.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.'library';

/*
 * Prepend the library/, tests/, and models/ directories to the
 * include_path. This allows the tests to run out of the box.
 */
$path = array($models, $library, $tests, $library_test, get_include_path());
set_include_path(implode(PATH_SEPARATOR, $path));


/* register the library classes */
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Oauth_');

// /**
//  * Register autoloader
//  */
// require_once 'Zend/Loader.php';
// Zend_Loader::registerAutoload();

// /**
//  * Store application root in registry
//  */
// Zend_Registry::set('testRoot', BASE_PATH);
// Zend_Registry::set('testBootstrap', BASE_PATH . '/application/bootstrap.php');

/*
 * Unset global variables that are no longer needed.
 */
unset($library, $models, $controllers, $tests, $path);