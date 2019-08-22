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

    public function getPage($id_page)
    {
        return Pages::where('id_page',$id_page)->first();
    }

    public function edit($id_page,$title,$content)
    {
        return Pages::where('id_page',$id_page)->update([
            'title' => $title,
            'content' => $content
        ]);
    }
}