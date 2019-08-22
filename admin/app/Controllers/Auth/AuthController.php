<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\Administrators;
use Slim\Views\Twig as View;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Respect\Validation\Validator as v;
use App\Validation\Validator;

use App\Tools\Tools;

class AuthController extends Controller
{

  public function getSignIn($request, $response)
  {
    return $this->container->view->render($response, 'auth/signin.twig');
  }

  public function postSignIn($request, $response)
  {
    $auth = $this->container->auth->attempt(
      $request->getParam('email'),
      $request->getParam('password')
    );
    
    if (!$auth) {
      $this->container->flash->addMessage('error', 'Algo esta mal, intenta nuevamente');
      return $response->withRedirect($this->container->router->pathFor('auth.signin'));
    }
    $this->container->flash->addMessage('success', 'Bienvenido');
    return $response->withRedirect($this->container->router->pathFor('home'));
  }


  public function getSignOut($request, $response)
  {
    $this->container->auth->logout();
    $this->container->flash->addMessage('success', 'Saliste correctamente');
    return $response->withRedirect($this->container->router->pathFor('home'));
  }

  public function resetPassword($request, $response)
  {
    return $this->container->view->render($response, 'auth/reset.twig');
  }

  public function postResetPassword($request, $response)
  {
    $validation = $this->container->validator->validate($request, [
      'email' => v::noWhitespace()->notEmpty()->email(),
    ]);
    if ($validation->failed()) {
      return $response->withRedirect($this->container->router->pathFor('auth.password.reset'));
    }
    $verify = User::where('email', $request->getParam('email'))->count();
    if ($verify = 1) {
      $new_password = Tools::randomPassword();
      $user = User::where('email', $request->gerParam('email'))
        ->update('password', password_hash($new_password , PASSWORD_DEFAULT));
      $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
      try {
        //Server settings
        // $mail->SMTPDebug = 2;                                       // Enable verbose debug output
        // $mail->isSMTP();                                            // Set mailer to use SMTP
        // $mail->Host       = 'smtp.gmail.com';                        // Specify main and backup SMTP servers
        // $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        // $mail->Username   = 'jeiriart@gmail.com';                     // SMTP username
        // $mail->Password   = 'patraz028809634';                               // SMTP password
        //$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        // $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($this->container->app_email, 'Mi perro y yo');
        $mail->addAddress($request->getParam('email'));     // Add a recipient
        $mail->CharSet = 'UTF-8';

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '!Contraseña cambiada¡';
        $mail->Body    = 'Hola tu contraseña se reseteo correctamente, la nueva contraseña es: <br>'.$new_password;
        $mail->AltBody = 'Hola tu contraseña se reseteo correctamente, la nueva contraseña es: <br>'.$new_password;

        $mail->send();
      } catch (\PHPMailer\PHPMailer\Exception $e) {
        $this->container->flash->addMessage('error', $mail->ErrorInfo);
      }
      $this->container->flash->addMessage('success', 'Se genero una nueva contraseña para tu cuenta, revisa tu email.');
      return $response->withRedirect($this->container->router->pathFor('auth.login'));
    } else {
      $this->container->flash->addMessage('error', 'El email no pertenece a ningun usuario activo.');
      return $response->withRedirect($this->container->router->pathFor('auth.password.reset'));
    }
  }
}
