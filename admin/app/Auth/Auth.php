<?php

namespace App\Auth;

use App\Models\User;

class Auth
{
  public function admin()
  {
    if(isset($_SESSION['admin'])){
      return User::find($_SESSION['admin']);
    }

  }

  public function check()
  {
    return isset($_SESSION['admin']);
  }

  public function attempt($email, $password)
  {
    $admin = User::where('email', $email)->first();

    if(!$admin){
      return false;
    }

    if(password_verify($password, $admin->password) AND $admin->status === 1 AND $admin->is_admin === 1){
      $_SESSION['admin'] = $admin->id;
      return true;
    }

    return false;

  }

  public function logout()
  {
    unset($_SESSION['admin']);
  }

}
