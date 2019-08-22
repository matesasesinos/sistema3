<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  protected $table = 'users';
  public $timestamps = false;
  protected $fillable = [
    'name',
    'lastname',
    'phone',
    'email',
    'password',
    'status'
  ];

  public function getUsers()
  {
    return User::all();
  }
  public function blogs()
  {
    return User::hasMany('App\Models\Blog', 'id_user');
  }
  public function setPassword($password)
  {
    $this->update([
      'password' => password_hash($password, PASSWORD_DEFAULT),
    ]);
  }

  public function getUser($id)
  {
    return User::where('id',$id)->first();
  }

  
}
