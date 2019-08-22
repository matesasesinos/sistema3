<?php

namespace App\Controllers\Page;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\Pages;
use Slim\Views\Twig as View;

use Respect\Validation\Validator as v;
use App\Validation\Validator;

use App\Tools\Tools;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PageController extends Controller
{
    public function getPage($request,$response,$args)
    {
        $pages = Pages::getPage($args['link_rewrite']);

        return $this->container->view->render($response, 'pages/page.twig', ['pages' => $pages]);
    }

    public function contact($request, $response)
    {
        return $this->container->view->render($response, 'pages/contact.twig');
    }

    public function postContact($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
            'name' => v::notEmpty()->alpha(),
            'email' => v::noWhitespace()->notEmpty()->email(),
            'subject' => v::notEmpty(),
            'message' => v::notEmpty()
          ]);
          if ($validation->failed()) {
            return $response->withRedirect($this->container->router->pathFor('pages.contact'));
          }

          $name = $request->getParam('name');
          $xmail = $request->getParam('email');
          $subject = $request->getParam('subject');
          $message = $request->getParam('message');
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
              $mail->setFrom($xmail, 'Mi perro y yo');
              $mail->addAddress($xmail, $name);     // Add a recipient
              $mail->CharSet = 'UTF-8';
          
              // Content
              $mail->isHTML(true);                                  // Set email format to HTML
              $mail->Subject = '!Hola Administrador! Hay un mensaje para vos';
              $mail->Body    = 'Nombre: '.$name.'<br />Email: '.$xmail.'<br /> Asunto: '.$subject.'<p>'.$message.'</p>';
              $mail->AltBody = 'Nombre: '.$name.'<br />Email: '.$xmail.'<br /> Asunto: '.$subject.'<p>'.$message.'</p>';
          
              $mail->send();
          } catch (\PHPMailer\PHPMailer\Exception $e) {
              $this->container->flash->addMessage('error', $mail->ErrorInfo);
          }
          $this->container->flash->addMessage('success', 'Tu mensaje se envió correctamente. Te responderemos a la brevedad.');
          return $response->withRedirect($this->container->router->pathFor('pages.contact'));
    }
}