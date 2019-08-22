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
    public function getAllPage($request,$response)
    {
        $pages = Pages::getAll();
        return $this->container->view->render($response, 'pages/list.twig', ['pages' => $pages]);
    }
    public function getPage($request,$response,$args)
    {
        $pages = Pages::getPage($args['id_page']);

        return $this->container->view->render($response, 'pages/page.twig', ['pages' => $pages]);
    }

    public function postEditPage($request,$response)
    {
        $pages = Pages::getPage($request->getParam('id_page'));
        $validation = $this->container->validator->validate($request, [
            'title' => v::notEmpty(),
            'content' => v::notEmpty(),
          ]);
          if ($validation->failed()) {
            return $response->withRedirect($this->container->router->pathFor('page.edit', ['id_page' => $request->getParam('id_page'), 'pages' => $pages]));
          }

          $page = Pages::edit($request->getParam('id_page'),$request->getParam('title'),$request->getParam('content'));
          $this->container->flash->addMessage('success', 'La pagina se edito correctamente.');
          return $response->withRedirect($this->container->router->pathFor('page.list'));
    }


}