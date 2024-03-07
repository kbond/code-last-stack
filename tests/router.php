<?php

if (is_file($_SERVER['DOCUMENT_ROOT'].\DIRECTORY_SEPARATOR.$_SERVER['SCRIPT_NAME'])) {
    return false;
}

$script = 'index.php';

$_SERVER = array_merge($_SERVER, $_ENV);
$_SERVER['SCRIPT_FILENAME'] = $_SERVER['DOCUMENT_ROOT'].\DIRECTORY_SEPARATOR.$script;

$_SERVER['SCRIPT_NAME'] = \DIRECTORY_SEPARATOR.$script;
$_SERVER['PHP_SELF'] = \DIRECTORY_SEPARATOR.$script;

require $script;
