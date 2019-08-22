<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->group('', function() use ($app){
  $app->get('/', 'HomeController:index')->setName('home');
  $app->get('/admins', 'AdminController:index')->setName('admin.list');
  $app->get('/admins/crear', 'AdminController:createAdmin')->setName('admin.create.form');
  $app->post('/admins/create', 'AdminController:postCreateAdmin')->setName('admin.create.post');
  $app->get('/admins/editar/{id}', 'AdminController:getAdmins')->setName('admin.edit.form');
  $app->post('/admins/edit', 'AdminController:postEditAdmin')->setName('admin.edit.post');
  $app->get('/usuarios', 'UserController:index')->setName('user.list');
  $app->get('/usuarios/{id}', 'UserController:getInfo')->setName('user.info');
  $app->post('/usuarios/borrar', 'UserController:delete')->setName('user.delete');
  $app->post('/user/edit', 'UserController:updateInfo')->setName('user.change');
  $app->get('/entradas', 'BlogController:index')->setName('blog.list');
  $app->get('/editar/{id}', 'BlogController:getEntryEdit')->setName('blog.edit');
  $app->post('/blog/edit', 'BlogController:editEntry')->setName('blog.editEntry');
  $app->get('/publicar', 'BlogController:getForm')->setName('blog.publish');
  $app->post('/blog/create', 'BlogController:postEntry')->setName('blog.create');
  $app->post('/blog/delete', 'BlogController:delPost')->setName('blog.delete');
  $app->get('/paginas', 'PageController:getAllPage')->setName('page.list');
  $app->get('/paginas/{id_page}', 'PageController:getPage')->setName('page.edit');
  $app->post('/page/edit', 'PageController:postEditPage')->setName('page.editPage');
})->add(new AuthMiddleware($container));


$app->group('', function() use ($app){
  $app->get('/ingresar', 'AuthController:getSignIn')->setName('auth.signin');
  $app->post('/auth/signin', 'AuthController:postSignIn')->setName('auth.login');
})->add(new GuestMiddleware($container));


$app->group('', function() use ($app) {
  $app->get('/salir', 'AuthController:getSignOut')->setName('auth.signout');
})->add(new AuthMiddleware($container));

