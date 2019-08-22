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
    public function index($request, $response)
    {
        $users = User::getUsers();
        return $this->container->view->render($response, 'user/list.twig', ['users' => $users]);
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
            return $response->withRedirect($this->container->router->pathFor('user.info', ['id' => $request->getParam('id')]));
        } else {
            $user = User::where('id', $request->getParam('id'))->update([
                'name' => $request->getParam('name'),
                'lastname' => $request->getParam('lastname'),
                'phone' => $request->getParam('phone'),
                'email' => $request->getParam('email')
            ]);
            $this->container->flash->addMessage('success', 'Los datos se modificaron exitosamente');
            $users = User::getUsers();
            return $response->withRedirect($this->container->router->pathFor('user.list', ['users' => $users]));
        }
    }
    
    

    

    public function delete($request,$response)
    {
        $user = User::deleteUser($request->getParam('id'));
        $users = User::getUsers();
        $this->container->flash->addMessage('success', 'El usuario fue eliminado exitosamente.');
        return $response->withRedirect($this->container->router->pathFor('user.list', ['users' => $users]));
    }
}
