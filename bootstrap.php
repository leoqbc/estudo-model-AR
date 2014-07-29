<?php

function loadLibs($class) 
{
    $dir = dirname(__FILE__);

    $folder = explode('\\', $class);

    if (count($folder) < 3) {
        return false;
    }

    $file = "$dir\\{$folder[1]}\\{$folder[2]}.php";

    if (file_exists($file)) {
        require_once($file);
        return true;
    }
}

function loadModels($class) 
{
    $dir = dirname(__FILE__);

    $folder = explode('\\', $class);

    if (count($folder) < 3) {
        return false;
    }

    echo $file = "$dir\\{$folder[1]}\\{$folder[2]}.php";

    if (file_exists($file)) {
        require_once($file);
        return true;
    }
}

// Registra as pastas Models e Library para
// ficarem no outro load
spl_autoload_register('loadLibs');
spl_autoload_register('loadModels');

ARMODEL\Library\Banco::dInjector(array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'dbname'    => 'seu banco',
    'user'      => 'root',
    'pass'      => 'sua senha'
));