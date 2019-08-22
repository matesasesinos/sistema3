<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'pages';
    public $timestamps = false;
    protected $fillable = [
        'id_page',
        'title',
        'content',
        'status',
        'seo_title',
        'seo_description',
        'seo_tags',
        'link_rewrite'
    ];

    public function getAll()
    {
        return Pages::all();
    }

    public function getPage($link_rewrite)
    {
        return Pages::where('link_rewrite',$link_rewrite)->first();
    }
}