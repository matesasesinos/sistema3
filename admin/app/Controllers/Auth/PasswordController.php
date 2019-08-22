<?php
namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\Administrators;
use Slim\Views\Twig as View;

use Respect\Validation\Validator as v;
use App\Validation\Validator;

class PasswordController extends Controller
{

  public function getChangePassword($request, $response)
  {
    return $this->container->view->render($response, 'auth/password/change.twig');
  }

  public function postChangePassword($request, $response)
  {
    $validation = $this->container->validator->validate($request, [
      'password_old' => v::noWhitespace()->notEmpty()->matchesPassword($this->container->auth->user()->password),
      'password' => v::noWhitespace()->notEmpty()
    ]);

    if($validation->failed()){
      return $response->withRedirect($this->container->router->pathFor('auth.password.change'));
    }

    $this->container->auth->user()->setPassword($request->getParam('password'));

    $this->container->flash->addMessage('success', 'Contraeña Cambiada');
    return $response->withRedirect($this->container->router->pathFor('home'));

  }

}
