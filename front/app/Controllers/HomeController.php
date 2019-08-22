<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\Blog;
use Slim\Views\Twig as View;

use Respect\Validation\Validator as v;
use App\Validation\Validator;

class HomeController extends Controller{

  public function index($request, $response)
  {
	  $home = Blog::join('blog_categories', 'blog_post.id_blog_category', 'blog_categories.id_category')
                  ->join('users', 'blog_post.id_user', 'users.id')
                  ->select('blog_post.*', 'blog_categories.id_category', 'blog_categories.name as category_name', 'users.name as author_name')
                  ->where('blog_post.status', '=', '1')
                  ->where('blog_categories.status', '=', '1')
                  ->get();
    return $this->container->view->render($response, 'home.twig', ['home' => $home]);
  }

}
