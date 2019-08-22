<?php

namespace App\Middleware;

class AdminLoginMiddleware extends Middleware
{

  public function __invoke($request, $response, $next)
  {

    if (!$this->container->auth_admin->check_admin())
    {
      $this->container->flash->addMessage('error', 'Solo administradores');
      return $response->withRedirect($this->container->router->pathFor('login'));
    }

    $response = $next($request, $response);
    return $response;

  }

}
