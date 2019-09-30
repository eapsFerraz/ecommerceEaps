<?php
session_start();
require_once ("vendor/autoload.php");

use \Slim\Slim;
use \eaps\Page;
use \eaps\PageAdmin;
use \eaps\Model\User;

$app = new \Slim\Slim();
$app->config('debug', true);

$app->get('/', function (){
   $page = new Page();
   $page->setTpl("index");
});

$app->get('/admin', function (){
    User::verifyLogin();

    $page = new PageAdmin();
    $page->setTpl("index");
});

$app->get('/admin/login', function(){
    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false

    ]);
    $page->setTpl("login");
});

$app->post('/admin/login', function(){
    User::login($_POST["login"], $_POST["password"]);
    header("Location: /admin");
    exit;
});

$app->run();