<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
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
    //$this->container->flash->addMessage('success', 'Iniciaste sesión correctamente');
    return $response->withRedirect($this->container->router->pathFor('user.panel'));
  }

  public function getSignUp($request, $response)
  {
    return $this->container->view->render($response, 'auth/signup.twig');
  }

  public function postSignUp($request, $response)
  {
    $validation = $this->container->validator->validate($request, [
      'name' => v::notEmpty()->alpha(),
      'lastname' => v::notEmpty()->alpha(),
      'phone' => v::notEmpty(),
      'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
      'password' => v::noWhitespace()->notEmpty(),
    ]);

    if ($validation->failed()) {
      return $response->withRedirect($this->container->router->pathFor('auth.signup'));
    }
    $name = $request->getParam('name');
    $pass = $request->getParam('password');
    $xmail = $request->getParam('email');
    $user = User::create([
      'name' => $request->getParam('name'),
      'lastname' => $request->getParam('lastname'),
      'phone' => $request->getParam('phone'),
      'email' => $request->getParam('email'),
      'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
      'status' => $request->getParam('status')
    ]);
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
      $mail->addAddress($xmail, $name);     // Add a recipient
      $mail->CharSet = 'UTF-8';

      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = '!Hola ' . $name . '! Tu registro se realizo correctamente';
      $mail->Body    = '!Hola ' . $name . '! Te registraste correctamente en nuestra web, recorda que tu email para ingresar es: ' . $xmail . 'y tu contrasela ' . $pass . '. Gracias!';
      $mail->AltBody = 'Hola ' . $name . '! Te registraste correctamente en nuestra web, recorda que tu email para ingresar es: ' . $xmail . 'y tu contrasela ' . $pass . '. Gracias!';

      $mail->send();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
      $this->container->flash->addMessage('error', $mail->ErrorInfo);
    }
    $this->container->flash->addMessage('success', 'Te registraste correctamente');

    $this->container->auth->attempt($user->email, $request->getParam('password'));

    $router = $this->container->router;
    return $response->withRedirect($router->pathFor('home'));
  }

  public function getSignOut($request, $response)
  {
    $this->container->auth->logout();
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
