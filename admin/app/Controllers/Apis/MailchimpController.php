<?php

namespace App\Controllers\Apis;

use App\Controllers\Controller;
use Slim\Views\Twig as View;

use Respect\Validation\Validator as v;
use App\Validation\Validator;

use \DrewM\MailChimp\MailChimp;

class MailchimpController extends Controller
{
    public function getFormMc($request,$response)
    {
        return $response->withRedirect($this->container->router->pathFor('api.newsletter'));
    }

    public function postMailchimp($request,$response)
    {
        $validation = $this->container->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()
          ]);
          if($validation->failed()){
            return $response->withRedirect($this->container->router->pathFor('api.newsletter'));
          } 
          
        $mailchimp = new \DrewM\MailChimp\MailChimp($this->container->mailchimp_apikey);
        $list_id = $this->container->mailchimp_listid;
        $result = $mailchimp->post("lists/$list_id/members", [
            'email_address' => $request->getParam('email'),
            'status'        => 'subscribed',
        ]);
        $this->container->flash->addMessage('success', 'Muchas gracias por inscribirte a nuestro Newsletter!');
        return $response->withRedirect($this->container->router->pathFor('api.newsletter'));

    }
}