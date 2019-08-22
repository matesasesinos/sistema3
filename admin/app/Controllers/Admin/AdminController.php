<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Administrators;
use Slim\Views\Twig as View;

use Respect\Validation\Validator as v;
use App\Validation\Validator;

class AdminController extends Controller
{
    public function index($request, $response)
    {
        $admins = Administrators::getAll();
        return $this->container->view->render($response, 'admin/list.twig', ['admins' => $admins]);
    }

    public function createAdmin($request, $response)
    {
        return $this->container->view->render($response, 'admin/create.twig');
    }

    public function postCreateAdmin($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
            'name' => v::notEmpty()->alpha(),
            'email' => v::noWhitespace()->notEmpty()->email()->adminEmailAvailable(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->container->router->pathFor('admin.create.form'));
        }
        $admin = Administrators::createAdmin(
            $request->getParam('name'),
            $request->getParam('lastname'),
            $request->getParam('phone') ,
            $request->getParam('email'), 
            password_hash($request->getParam('password'), PASSWORD_DEFAULT)
        );
        $this->container->flash->addMessage('success', 'El administrador fue creado correctamente.');
        return $response->withRedirect($this->container->router->pathFor('admin.list'));
    }

    public function getAdmins($request, $response, $args)
    {
        $admin = Administrators::getAdmin($args['id']);
        return $this->container->view->render($response, 'admin/edit.twig', ['admin' => $admin]);
    }

    public function postEditAdmin($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
            'name' => v::notEmpty()->alpha(),
            'lastname' => v::notEmpty()->alpha(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->container->router->pathFor('admin.edit.form'));
        }
        if (!empty($request->getParam('password'))) {
            $admin = Administrators::where('id', $request->getParam('id'))->update([
                'name' => $request->getParam('name'),
                'lastname' => $request->getParam('lastname'),
                'phone' => $request->getParam('phone'),
                'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
                'status' => $request->getParam('status')
            ]);
        } else {
            $admin = Administrators::where('id', $request->getParam('id'))->update([
                'name' => $request->getParam('name'),
                'lastname' => $request->getParam('lastname'),
                'phone' => $request->getParam('phone'),
                'status' => $request->getParam('status')
            ]);
        }
        $this->container->flash->addMessage('success', 'El administrador fue editado correctamente.');
        return $response->withRedirect($this->container->router->pathFor('admin.list'));
    }
}