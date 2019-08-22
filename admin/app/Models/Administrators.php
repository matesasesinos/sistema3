<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Administrators extends Model
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
  
    public function getAll()
    {
      return User::where('is_admin',1)->get();
    }

    public function setPassword($password)
    {
      $this->update([
        'password' => password_hash($password, PASSWORD_DEFAULT),
      ]);
    }
    
    public function createAdmin($name,$lastname,$phone,$email,$password)
    {
        return User::create([
            'name' => $name,
            'lastname' => $lastname,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
            'status' => 1,
            'is_admin' => 1    
        ]);
    }

    public function getAdmin($id)
    {
      return User::where('id',$id)->first();
    }

}
