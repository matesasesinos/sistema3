<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class AdminEmailAvailableException extends ValidationException
{

  public static $defaultTemplates = [

    self::MODE_DEFAULT => [
        self::STANDARD => 'El email ya esta registrado como administrador',
    ],
  ];


}
