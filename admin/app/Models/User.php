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
    'status',
    'is_admin'
  ];

  public function getUsers()
  {
    return User::where('is_admin',0)->get();
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

  public function deleteUser($id)
  {
    return User::find($id)->delete();
  }
  
}
