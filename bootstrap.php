<?php

function loadLibs($class) 
{
    $dir = dirname(__FILE__);
    $file = "$dir/lib/$class.php";

    if (file_exists($file)) {
        require_once($file);
        return true;
    }
}

function loadModels($class) 
{
    $dir = dirname(__FILE__);
    $file = "$dir/models/$class.php";

    if (file_exists($file)) {
	require_once($file);
	return true;
    }
}

// Registra as pastas model e lib para
// ficarem no outro load
spl_autoload_register('loadLibs');
spl_autoload_register('loadModels');

Banco::dInjector(array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'dbname'    => 'banco',
    'user'      => 'root',
    'pass'      => ''
));
