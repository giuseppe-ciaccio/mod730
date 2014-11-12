<?php

/*
 * Author:      Artur Tolstenco
 * Data:        15/05/2013
 * Description: This script creates the database sql schema and loads the data
 *              for both databases - the rs database and the data database
 */

/*
 * Initialize the application path and autoloading
 */
defined('APPLICATION_PATH') || 
define('APPLICATION_PATH', realpath(dirname(__FILE__).'/../application'));

set_include_path(implode(PATH_SEPARATOR, array(APPLICATION_PATH.'/../library',
                                                get_include_path(),)));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

/*
 * Definition of CLI options
 */
$getopt = new Zend_Console_Getopt(array(
            'data_instance-s'   =>  'Instance name of the specific DATA SERVER.',
            'rs_dbschema-s'     =>  'The file that contains the database schema '.
                                    'for the RESOURCE SERVER (the part that '.
                                    'manage the interaction between the '.
                                    'Resource Server and the Client).',
            'rs_dbdata-s'       =>  'The file that contains the default data '.
                                    'for the RESOURCE SERVER (the part that '.
                                    'manage the interaction between the '.
                                    'Resource Server and the Client).',
            'rs_withdata'       =>  'Load the data for the RESOURCE SERVER (the '.
                                    'part that manage the interaction between '.
                                    'the Resource Server and the Client).',
            'data_dbschema-s'   =>  'The file that contains the database schema '.
                                    'for the DATA SERVER (the back end data '.
                                    'server).',
            'data_dbdata-s'     =>  'The file that contains the default data '.
                                    'for the DATA SERVER (the back end data '.
                                    'server).',
            'data_withdata'     =>  'Load the datafor the DATA SERVER (the back '.
                                    'end data server).',
            'env-s'             =>  'Application environment for which to '.
                                    'create database (defaults to development)',
            'help|h'            =>  'Help -- usage message'));

try {
	$getopt->parse();
} catch (Zend_Console_Getopt_Exception $e) {
	echo $e->getUsageMessage();
	return false;
}

if ($getopt->getOption('h')) {
	echo $getopt->getUsageMessage();
	return true;
}

// Initialize values based on presence or absence of CLI options
$env = $getopt->getOption('env');

$rs_withdata = $getopt->getOption('rs_withdata');
$rs_db_schema_file = $getopt->getOption('rs_dbschema');
$rs_db_data_file = $getopt->getOption('rs_dbdata');

$data_withdata = $getopt->getOption('data_withdata');
$data_db_schema_file = $getopt->getOption('data_dbschema');
$data_db_data_file = $getopt->getOption('data_dbdata');

$data_instance = $getopt->getOption('data_instance');

if ($data_instance == null) {
	echo 'Must specify the instance of the DATA SERVER.'.PHP_EOL;
	return false;
}

if ($rs_db_schema_file == null || $data_db_schema_file == null) {
	echo 'Must provide the the schema files for the RESOURCE SERVER and the '.
	     'DATA SERVER'.PHP_EOL;
	return false;
}

if ($rs_withdata == true && $rs_db_data_file == null) {
	echo 'Must provide the data file for the RESOURCE SERVER.'.PHP_EOL;
	return false;
}

if ($data_withdata == true && $data_db_data_file == null) {
	echo 'Must provide the data file for the DATA SERVER.'.PHP_EOL;
	return false;
}


defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (null == $env) ? 'development' : $env);


/*
 * Initialize Zend_Application
 */
try {
	$application = new Zend_Application(APPLICATION_ENV, 
	                                    APPLICATION_PATH.'/configs/application.ini');
} catch (Zend_Config_Exception $e) {
	echo 'The application environment is invalid "'.$env.'"'.PHP_EOL;
	return false;
}

/*
 * RESOURCE SERVER database
 */
$bootstrap = $application->getBootstrap();
$bootstrap->bootstrap('db');
$dbAdapter = $bootstrap->getResource('db');

echo PHP_EOL.'Writing the RESOURCE SERVER database in (control-c to stop): '.PHP_EOL;
for ($x = 3; $x > 0; $x--) {
    echo $x . "\r"; 
    sleep(1);
}

try {
	$schemaSql = file_get_contents($rs_db_schema_file);
	if (!$schemaSql)
		throw new Exception('Cannot read the file that contains the '.
		                    'RESOURCE SERVER db schema.');
	if ($dbAdapter->getConnection()->exec($schemaSql))
		throw new Exception('The file that contains the RESOURCE SERVER db '.
		                    'schema contains invalid queries.');
	
	echo 'The RESOURCE SERVER database schema loaded successfully.'.PHP_EOL;

	if ($rs_withdata) {
		$dataSql = file_get_contents($rs_db_data_file);
		if (!$dataSql)
			throw new Exception('Cannot read the file that contains the '.
			                    'RESOURCE SERVER db default data.');
		if ($dbAdapter->getConnection()->exec($dataSql))
			throw new Exception('The file that contains the RESOURCE SERVER db '.
			                    'default data contains invalid queries.');
		echo 'Data loaded for RESOURCE SERVER successfully.'.PHP_EOL;
	}
} catch (Exception $e) {
	echo 'There was an error:'.PHP_EOL;
	echo $e->getMessage().PHP_EOL;
	return false;
}

echo PHP_EOL.'================================================================================'.PHP_EOL.PHP_EOL;

/*
 * DATA SERVER database
 */
$bootstrap->bootstrap();
$data_dbAdapter = Zend_Registry::get($data_instance);

echo 'Writing the DATA SERVER database in (control-c to stop): '.PHP_EOL;
for ($x = 3; $x > 0; $x--) {
    echo $x . "\r"; 
    sleep(1);
}

try {
	$schemaSql = file_get_contents($data_db_schema_file);
	if (!$schemaSql)
		throw new Exception('Cannot read the file that contains the '.
		                    'DATA SERVER db schema.');
	if ($data_dbAdapter->getConnection()->exec($schemaSql))
		throw new Exception('The file that contains the DATA SERVER db '.
			                'default data contains invalid queries.');
	
	echo 'The DATA SERVER database schema loaded successfully.'.PHP_EOL;

	if ($data_withdata) {
		$dataSql = file_get_contents($data_db_data_file);
		if (!$dataSql)
			throw new Exception('Cannot read the file that contains the '.
			                    'DATA SERVER db default data.');
		if ($data_dbAdapter->getConnection()->exec($dataSql))
			throw new Exception('The file that contains the DATA SERVER db '.
			                    'default data contains invalid queries.');
		echo 'Data loaded for DATA SERVER successfully.'.PHP_EOL;
	}
} catch (Exception $e) {
	echo 'There was an error:'.PHP_EOL;
	echo $e->getMessage().PHP_EOL;
	return false;
}

return true;
