<?php

use Respect\Validation\Validator as v;
use App\View\Factory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

session_start();

require __DIR__ . '/../vendor/autoload.php';

LengthAwarePaginator::viewFactoryResolver(function () {
  return new Factory;
});

LengthAwarePaginator::defaultView('pagination/bootstrap.twig');

Paginator::currentPathResolver(function () {
  return isset($_SERVER['REQUEST_URI']) ? strtok($_SERVER['REQUEST_URI'], '?') : '/';
});

Paginator::currentPageResolver(function () {
  return isset($_GET['page']) ? $_GET['page'] : 1;
});

$app = new \Slim\App([
  'settings' => [
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false, // Allow the web server to send the content-length header
    'db' => [
      'driver' => 'mysql',
      'host' => 'localhost',
      'database' => 'cms',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
      'collation' => 'utf8_general_ci',
      'prefix' => ''
    ]
  ],
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {

  return $capsule;
};
$directory = dir(getcwd());
$container['upload_directory'] = $directory->path . '/assets/img/posts/';
$container['mailchimp_apikey'] = '30305e62e5d280e508f396243fdf78d5-us3';
$container['mailchimp_listid'] = '39d5a2c3bf';
$container['mailchimp_url'] = 'https://us3.api.mailchimp.com/3.0/lists/';
$container['app_email'] = 'info@miperroyo.com.ar';

$container['view'] = function ($container) {

  $view = Factory::getEngine();

  $view->addExtension(new \Slim\Views\TwigExtension(
    $container->router,
    $container->request->getUri()
  ));

  $view->addExtension(new Twig_Extensions_Extension_Intl());
  $view->addExtension(new \Twig_Extension_Debug());
  $view->addExtension(new Twig_Extensions_Extension_Text());
  $view->getEnvironment()->addGlobal('auth', [
    'check' => $container->auth->check(),
    'user' => $container->auth->user(),
  ]);

  $view->getEnvironment()->addGlobal('flash', $container->flash);

  return $view;
};

$container['validator'] = function ($container) {
  return new App\Validation\Validator;
};

$container['HomeController'] = function ($container) {
  return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function ($container) {
  return new \App\Controllers\Auth\AuthController($container);
};

$container['PasswordController'] = function ($container) {
  return new \App\Controllers\Auth\PasswordController($container);
};

$container['UserController'] = function ($container) {
  return new \App\Controllers\User\UserController($container);
};

$container['BlogController'] = function ($container) {
  return new \App\Controllers\Blog\BlogController($container);
};

$container['PageController'] = function ($container) {
  return new \App\Controllers\Page\PageController($container);
};

$container['MailchimpController'] = function ($container) {
  return new \App\Controllers\Apis\MailchimpController($container);
};

$container['tools'] = function ($container) {
  return new \App\Tools\Tools;
};

$container['csrf'] = function ($container) {
  return new  \Slim\Csrf\Guard;
};

$container['auth'] = function ($container) {
  return new  \App\Auth\Auth;
};


$container['flash'] = function () {
  return new \Slim\Flash\Messages();
};

Illuminate\Pagination\Paginator::currentPageResolver(function ($pageName = 'page') use ($container) {

  $page = $container->request->getParam($pageName);

  if (filter_var($page, FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
    return $page;
  }
  return 1;
});

$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);

v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';