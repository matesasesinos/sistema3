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
                  ->select('blog_post.*', 
                  'blog_categories.id_category', 
                  'blog_categories.name as category_name', 
                  'users.name as author_name', 'users.lastname as author_lastname')
                  ->take(5)
                  ->orderBy('id_post', 'desc')
                  ->get();
    $users = User::where('is_admin',0)->take(5)->orderBy('id','desc')->get();
    return $this->container->view->render($response, 'home.twig', ['home' => $home, 'users' => $users]);
  }

}
