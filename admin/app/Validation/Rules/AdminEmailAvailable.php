<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

use App\Models\Administrators;

class AdminEmailAvailable extends AbstractRule
{

  public function validate($input)
  {

    return Administrators::where('email', $input)->count() === 0;

  }

}
