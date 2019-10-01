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

$app->get('/admin/logout', function (){
    User::logout();
    header("Location: /admin/login");
    exit;
});

$app->get("/admin/users", function(){
    User::verifyLogin();
    // estou listando todos os ususarios do banco de dados
    $users = User::listAll();
    $page = new PageAdmin();
    $page->setTpl("users", array(
        "users"=>$users
    ));
});

$app->get("/admin/users/create", function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("users-create");
});

$app->get("/admin/users/:iduser", function($iduser){
   User::verifyLogin();
   $page = new PageAdmin();
   $page->setTpl("users-update");
});

// salvar o usuario no banco de dados
$app->post("/admin/users/create", function(){
    User::verifyLogin();
});

//alterar o usuario do banco
$app->post("/admin/users/:iduser", function($iduser){
    User::verifyLogin();
});

// excluir o usuario
$app->post("/admin/users/:iduser/delete", function($iduser){
    User::verifyLogin();
});



$app->run();