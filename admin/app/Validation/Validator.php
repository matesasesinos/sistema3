<?php

namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;


class Validator
{
  protected $errors;

  public function validate($request, array $rules)
  {
    foreach($rules as $field => $rule){
      try{
          $rule->setName(ucfirst($field))->assert($request->getParam($field));
      } catch(NestedValidationException $e) {
          $errors = $e->findMessages([
            'usernameAvailable' => 'El usuario ya existe en la base de datos',
            'emailAvailable' => 'El email ya existe en la base de datos',
            'notEmpty' => 'El campo no puede estar vacío',
            'noWhitespace' => 'El campo no puede contener espacios',
            'email' => 'El campo debe contener un e-mail válido',
            'mimetype' => 'El tipo de archivo no es válido',
            'size' => 'El tamaño del archivo es mayor al permitido',
            'alpha' => 'El campo solo acepta letras',
            'length' => 'El campo debe tener un minimo de {{minValue}} y un maximo de {{maxValue}} caracteres',
            'image' => 'El campo debe contener una imagen'
        ]);
        $filteredErrors = array_filter($errors); 
          $this->errors[$field] = $e->getMessages();
      }
    }

    $_SESSION['errors'] = $this->errors;
    return $this;
  }

  public function failed()
  {
    return !empty($this->errors);
  }

}
