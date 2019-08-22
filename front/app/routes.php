<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function() use ($app){
  
  $app->get('/noticias', 'BlogController:index')->setName('blog');
  $app->get('/noticia/{link_rewrite}', 'BlogController:getEntry')->setName('blog.entry');
  $app->get('/categoria/{link_rewrite}', 'BlogController:getByCategory')->setName('blog.category');
  $app->get('/busqueda', 'BlogController:search')->setName('blog.search');
});

$app->group('', function() use ($app){
  $app->get('/registro', 'AuthController:getSignUp')->setName('auth.signup');
  $app->post('/auth/signup', 'AuthController:postSignUp')->setName('auth.register');

  $app->get('/ingresar', 'AuthController:getSignIn')->setName('auth.signin');
  $app->post('/auth/signin', 'AuthController:postSignIn')->setName('auth.login');
   
  $app->get('/recuperar-contrasenia', 'AuthController:resetPassword')->setName('auth.password.reset');
  $app->post('/auth/reset', 'AuthController:postResetPassword')->setName('auth.password.change');
})->add(new GuestMiddleware($container));


$app->group('', function() use ($app) {
  $app->get('/salir', 'AuthController:getSignOut')->setName('auth.signout');
  $app->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
  $app->post('/auth/password/change', 'PasswordController:postChangePassword');
})->add(new AuthMiddleware($container));

$app->group('', function () use ($app){
  $app->get('/mi-perfil', 'UserController:index')->setName('user.panel');
  $app->get('/mis-datos/{id}', 'UserController:getInfo')->setName('user.data');
  $app->post('/user/edit', 'UserController:updateInfo')->setName('user.change');
  $app->get('/mis-publicaciones/{id}', 'UserController:getEntrys')->setName('user.entrys');
  $app->get('/publicar', 'UserController:getForm')->setName('user.publish');
  $app->post('/blog/create', 'BlogController:postEntry')->setName('blog.create');
  $app->get('/mis-datos/cambiar-password/{id}', 'UserController:getInfoPassword')->setName('user.password');
  $app->post('/user/password', 'UserController:postChangePassword')->setName('user.password.change');
  $app->get('/editar/{id}', 'BlogController:getEntryEdit')->setName('blog.edit');
  $app->post('/blog/edit', 'BlogController:editEntry')->setName('blog.editEntry');
})->add(new AuthMiddleware($container));

$app->get('/contacto', 'PageController:contact')->setName('pages.contact');
$app->post('/send/contact', 'PageController:postContact')->setName('pages.send');
$app->get('/#newsletter_form', 'MailchimpController:getFormMc')->setName('api.newsletter');
$app->post('/newsletter/suscribe', 'MailchimpController:postMailchimp')->setName('api.suscribe');
$app->get('/{link_rewrite}', 'PageController:getPage')->setName('pages.page');