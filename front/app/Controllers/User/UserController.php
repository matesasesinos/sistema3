<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogCategories;
use Slim\Views\Twig as View;

use Respect\Validation\Validator as v;
use App\Validation\Validator;

class UserController extends Controller
{
    public function index($request, $response, $args)
    {
        $id = $request->getParam('id');
        return $this->container->view->render($response, 'user/panel.twig', ['id' => $id]);
    }
    public function getInfo($request, $response, $args)
    {
        $user = User::getUser($args['id']);
        return $this->container->view->render($response, 'user/data.twig', ['user' => $user]);
    }

    public function getInfoPassword($request, $response, $args)
    {
        $user = User::getUser($args['id']);
        return $this->container->view->render($response, 'user/password.twig', ['user' => $user]);
    }

    public function updateInfo($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
            'name' => v::notEmpty()->alpha()->setTemplate('No puede estar vació'),
            'lastname' => v::notEmpty()->alpha()->setTemplate('No puede estar vació'),
            'email' => v::noWhitespace()->notEmpty()->email()->setTemplate('Ingrese un email valido'),
            'phone' => v::notEmpty()->setTemplate('No puede estar vació'),
        ]);
        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Ocurrio un error al actualizar');
            return $response->withRedirect($this->container->router->pathFor('user.data', ['id' => $request->getParam('id')]));
        } else {
            $user = User::where('id', $request->getParam('id'))->update([
                'name' => $request->getParam('name'),
                'lastname' => $request->getParam('lastname'),
                'phone' => $request->getParam('phone'),
                'email' => $request->getParam('email')
            ]);
            $this->container->flash->addMessage('success', 'Los datos se modificaron exitosamente');
            return $response->withRedirect($this->container->router->pathFor('user.data', ['id' => $request->getParam('id')]));
        }
    }
    public function postChangePassword($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
            'password_old' => v::noWhitespace()->notEmpty()->matchesPassword($this->container->auth->user()->password),
            'password' => v::noWhitespace()->notEmpty()
        ]);

        if ($validation->failed()) {
            return $response->withRedirect($this->container->router->pathFor('user.password', ['id' => $request->getParam('id')]));
        }

        $this->container->auth->user()->setPassword($request->getParam('password'));

        $this->container->flash->addMessage('success', 'Tu contraseña fue actualizada correctamente');
        return $response->withRedirect($this->container->router->pathFor('user.panel'));
    }
    public function getEntrys($request, $response, $args)
    {
        $entrys = Blog::getEntryByUser($args['id']);
        return $this->container->view->render($response, 'user/posts.twig', ['entrys' => $entrys]);
    }

    public function getForm($request, $response)
    {
        $categorys = BlogCategories::getCategories();
        return $this->container->view->render($response, 'user/publish.twig', ['category' => $categorys]);
    }

    
}
