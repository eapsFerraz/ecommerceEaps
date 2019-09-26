<?php
require_once ("vendor/autoload.php");

use DB\Sql;

$app = new \Slim\Slim();
$app->config('debug', true);

$app->get('/', function (){
   $page = new Page();
   $page->setTpl("index");
});
$app->run();