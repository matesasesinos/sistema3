<?php

namespace App\Controllers\Blog;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogCategories;
use Slim\Views\Twig as View;

use Slim\Http\UploadedFile;

use Respect\Validation\Validator as v;
use App\Validation\Validator;

use App\Tools\Tools;
use App\Tools\Upload;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Pagination\LengthAwarePaginator;

class BlogController extends Controller
{
  //entradas
  public function index($request, $response)
  {
    $blog = Blog::getBlog();
    $categories = BlogCategories::getCategories();
    return $this->container->view->render($response, 'blog/blog.twig', ['blog' => $blog, 'categories' => $categories]);
  }
  //por categoria
  public function getByCategory($request,$response,$args)
  {
    $blog = Blog::getByCategory($args['link_rewrite']);
    $category_names = BlogCategories::getOneCategory($args['link_rewrite']);
    $categories = BlogCategories::getCategories();
    return $this->container->view->render($response, 'blog/blog.twig', ['blog' => $blog, 'categories' => $categories, 'category_names' => $category_names]);
  }

  //por autor
  public function getEntryByAuthor($request, $response, $args)
  {
    $blog =  User::find($args['id_user'])->blogs;
  }

  //entrada
  public function getEntry($request, $response, $args)
  {
    $post = Blog::getEntry($args['link_rewrite']);
    $categories = BlogCategories::getCategories();
    return $this->container->view->render($response, 'blog/post.twig', ['post' => $post, 'categories' => $categories]);
  }

  //create
  public function postEntry($request, $response)
  {
    $validation = $this->container->validator->validate($request, [
      'id_category' => v::notEmpty()->noWhitespace()->setTemplate('Seleccione una categoría'),
      'title' => v::notEmpty(),
      'content' => v::notEmpty(),
      'id_user' => v::notEmpty()
    ]);
    if ($validation->failed()) {
      return $response->withRedirect($this->container->router->pathFor('user.publish'));
    }
    $directory = $this->container->upload_directory;
    $handle = new Upload($_FILES['cover'], 'es_ES');
    if ($handle->uploaded) {
      $img_name = 'cover_' . date('YmdHms') . rand(0, 99);
      $handle->file_new_name_body   = $img_name;
      $handle->image_resize         = true;
      $handle->image_x              = 768;
      $handle->image_y              = 1024;
      $handle->image_ratio_y        = true;
      $handle->image_max_width = 1024;
      $handle->image_min_width = 500;
      $handle->image_convert = 'jpg';
      $handle->jpeg_quality = 90;
      $handle->image_interlace = true;
      $handle->jpeg_size = 500000;
      $handle->process($directory);
      if ($handle->processed) {
        $cover = $img_name;
        $blog = Blog::create([
          'id_blog_category' => $request->getParam('id_category'),
          'title' => $request->getParam('title'),
          'summary' => $request->getParam('summary'),
          'content' => $request->getParam('content'),
          'id_user' => $request->getParam('id_user'),
          'date' => $request->getParam('date'),
          'status' => 0,
          'cover' => $cover . '.jpg',
          'link_rewrite' => Tools::seo_friendly_url($request->getParam('title'))
        ]);
        $handle->clean();
      } else {
        $this->container->flash->addMessage('error', $handle->error);
        return $response->withRedirect($this->container->router->pathFor('user.publish'));
      }
    }
    $user = User::getUser($request->getParam('id_user'));
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
      $mail->setFrom('publicaciones@miperroyyo.com', 'Publicaciones');
      $mail->addAddress($this->container->app_email, 'Mi perro y yo');     // Add a recipient


      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Nueva publicación';
      $mail->Body    = 'Hola, el usuario ' . $user->name . ' ' . $user->lastname . ' realizó una nueva publicación con el titulo "' . $request->getParam('title') . '", la publicación espera autorización.';
      $mail->AltBody = 'Hola, el usuario ' . $user->name . ' ' . $user->lastname . ' realizó una nueva publicación con el titulo "' . $request->getParam('title') . '", la publicación espera autorización.';

      $mail->send();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
      $this->container->flash->addMessage('error', $mail->ErrorInfo);
    }
    $this->container->flash->addMessage('success', 'La publicación se realizo correctamente, un administrador la revisara y aprobara.');
    return $response->withRedirect($this->container->router->pathFor('user.panel'));
  }

  //update
  public function getEntryEdit($request, $response, $args)
  {
    $post =  Blog::edit($args['id']);
    $categorys = BlogCategories::getCategories();
    return $this->container->view->render($response, 'user/edit.twig', ['post' => $post, 'category' => $categorys]);
  }

  public function editEntry($request, $response)
  {
    $post =  Blog::edit($request->getParam('id_post'));
    $categorys = BlogCategories::getCategories();
    $validation = $this->container->validator->validate($request, [
      'id_category' => v::notEmpty()->noWhitespace()->setTemplate('Seleccione una categoría'),
      'title' => v::notEmpty(),
      'content' => v::notEmpty(),
      'id_user' => v::notEmpty()
    ]);
    if ($validation->failed()) {
      return $response->withRedirect($this->container->router->pathFor('blog.edit', ['id' => $request->getParam('id_post'), 'post' => $post, 'category' => $categorys]));
    }
    $directory = $this->container->upload_directory;
    $handle = new Upload($_FILES['cover'], 'es_ES');
    if ($handle->uploaded) {
      $img_name = 'cover_' . date('YmdHms') . rand(0, 99);
      $handle->file_new_name_body   = $img_name;
      $handle->image_resize         = true;
      $handle->image_x              = 768;
      $handle->image_y              = 1024;
      $handle->image_ratio_y        = true;
      $handle->image_max_width = 1024;
      $handle->image_min_width = 500;
      $handle->image_convert = 'jpg';
      $handle->jpeg_quality = 90;
      $handle->image_interlace = true;
      $handle->jpeg_size = 500000;
      $handle->process($directory);
      if ($handle->processed) {
        $cover = $img_name;
        $blog = Blog::where('id_post', $request->getParam('id_post'))->update([
          'id_blog_category' => $request->getParam('id_category'),
          'title' => $request->getParam('title'),
          'summary' => $request->getParam('summary'),
          'content' => $request->getParam('content'),
          'date' => $request->getParam('date'),
          'status' => 0,
          'cover' => $cover . '.jpg',
          'link_rewrite' => Tools::seo_friendly_url($request->getParam('title'))
        ]);
        $handle->clean();
      }
    } else {
      $cover = $request->getParam('cover_now');
      $blog = Blog::where('id_post', $request->getParam('id_post'))->update([
        'id_blog_category' => $request->getParam('id_category'),
        'title' => $request->getParam('title'),
        'summary' => $request->getParam('summary'),
        'content' => $request->getParam('content'),
        'date' => $request->getParam('date'),
        'status' => 0,
        'cover' => $cover,
        'link_rewrite' => Tools::seo_friendly_url($request->getParam('title'))
      ]);
    }
    $user = User::getUser($request->getParam('id_user'));
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
      $mail->setFrom('publicaciones@miperroyyo.com', 'Publicaciones');
      $mail->addAddress($this->container->app_email, 'Mi perro y yo');  


      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Nueva publicación';
      $mail->Body    = 'Hola, el usuario ' . $user->name . ' ' . $user->lastname . ' realizó una nueva publicación con el titulo "' . $request->getParam('title') . '", la publicación espera autorización.';
      $mail->AltBody = 'Hola, el usuario ' . $user->name . ' ' . $user->lastname . ' realizó una nueva publicación con el titulo "' . $request->getParam('title') . '", la publicación espera autorización.';

      $mail->send();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
      $this->container->flash->addMessage('error', $mail->ErrorInfo);
    }
    $this->container->flash->addMessage('success', 'La publicación se edito correctamente, un administrador la revisara y aprobara.');
    return $response->withRedirect($this->container->router->pathFor('user.panel'));
  }

  //search
  public function search($request,$response)
  {
    $blog = Blog::getSearch($request->getParam('search'));
    $contar = $blog->count();
    $categories = BlogCategories::getCategories();
    return $this->container->view->render($response, 'blog/search.twig', ['blog' => $blog, 'categories' => $categories, 'contar' => $contar]);
  }
}