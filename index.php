<?php
require_once __DIR__ . "/vendor/autoload.php";

use sirJuni\Framework\Application\Application;
use sirJuni\Framework\View\VIEW;

// import the db config
require_once __DIR__ . "/App/config.php";

// set templates dir to load html files
VIEW::set_path(__DIR__ . "/templates");


// define the application root
// incase the project folder is not the one being served, but one of
// its parent folders is
const ROOT = '/Ecommer';         // change this as needed.

// load all the routes
require_once(__DIR__ . "/App/Routes/routes.php");

$app = new Application();
$app->handle();
?>