<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
  protected $table = 'blog_post';
  public $timestamps = false;
  protected $fillable = [
    'id_post',
    'id_blog_category',
    'id_user',
    'title',
    'summary',
    'content',
    'date',
    'cover',
    'status',
    'seo_title',
    'seo_description',
    'seo_tags',
    'link_rewrite'
  ];

  public function getBlog()
  {
    return Blog::join('blog_categories', 'blog_post.id_blog_category', 'blog_categories.id_category')
    ->join('users', 'blog_post.id_user', 'users.id')
    ->select('blog_post.*', 'blog_categories.id_category', 'blog_categories.link_rewrite as category', 'blog_categories.name as category_name', 'users.name as author_name')
    ->where('blog_post.status', '=', '1')
    ->where('blog_categories.status', '=', '1')
    ->orderBy('id_post','desc')
    ->paginate(9);
  }

  public function getByCategory($link_rewrite)
  {
    return Blog::join('blog_categories', 'blog_post.id_blog_category', 'blog_categories.id_category')
    ->join('users', 'blog_post.id_user', 'users.id')
    ->select('blog_post.*', 'blog_categories.id_category', 'blog_categories.link_rewrite as category', 'blog_categories.name as category_name', 'users.name as author_name')
    ->where('blog_post.status', '=', '1')
    ->where('blog_categories.status', '=', '1')
    ->where('blog_categories.link_rewrite', '=', $link_rewrite)
    ->orderBy('id_post','desc')
    ->paginate(9);
  }

  public function getSearch($search)
  {
    return Blog::join('blog_categories', 'blog_post.id_blog_category', 'blog_categories.id_category')
    ->join('users', 'blog_post.id_user', 'users.id')
    ->select('blog_post.*', 'blog_categories.id_category', 'blog_categories.link_rewrite as category', 'blog_categories.name as category_name', 'users.name as author_name')
    ->where('blog_post.status', '=', '1')
    ->where('blog_categories.status', '=', '1')
    ->where('blog_post.title', 'like', '%'.$search.'%')
    ->orderBy('id_post','desc')
    ->paginate(9);
  }

  public function users()
  {
    return Blog::hasMany('App\Models\User', 'id');
  }

  public function getEntry($link_rewrite)
  {
    return Blog::join('blog_categories', 'blog_post.id_blog_category', 'blog_categories.id_category')
    ->join('users', 'blog_post.id_user', 'users.id')
    ->select('blog_post.*', 'blog_categories.id_category', 'blog_categories.link_rewrite as category', 'blog_categories.name as category_name', 'users.*')
    ->where('blog_post.status', '=', '1')
    ->where('blog_categories.status', '=', '1')
    ->where('blog_post.link_rewrite','=',$link_rewrite)
    ->first();
  }

  public function edit($id_post)
  {
    return Blog::where('id_post',$id_post)->first();
  }

  public function getEntryByUser($id)
  {
    return Blog::where('id_user',$id)->get();
  }

}
