<?php

define ('BASEDIR', __DIR__);

function h($text) {
    return htmlspecialchars($text);
}

// set some php.ini-values (if possible)
error_reporting(22519);                 // E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED
ini_set('display_errors', 'On');
ini_set('html_errors', 'On');


// register function to automatically load classes
spl_autoload_register( function($class) {
    require_once('classes/' . $class . '.php');
});


// create connection to database                       
$dbh = new PDO('mysql:host=localhost;dbname=blog_project', 'root', '');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// start session
session_start();
