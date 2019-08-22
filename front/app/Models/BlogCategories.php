<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategories extends Model
{
  protected $table = 'blog_categories';
  public $timestamps = false;
  protected $fillable = [
    'id_category',
    'id_parent',
    'status',
    'name',
    'description',
    'cover',
    'seo_title',
    'seo_description',
    'seo_tags',
    'link_rewrite',
  ];

  public function getCategories()
  {
    return BlogCategories::all();
  }

  public function getOneCategory($link_rewrite)
  {
    return BlogCategories::where('link_rewrite', $link_rewrite)->first();
  }

  public function posts()
  {
    return BlogCategories::hasMany('App\Models\Blog', 'id_blog_category');
  }


}
