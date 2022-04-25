<?php

namespace App\Utils;

class Form
{

  private $errors;

  public function __construct(array $errors)
  {
    $this->errors = $errors;
  }

  public function input(string $key, string $label, string $type)
  {

    return
      '<div>
        <label for="field' . $key . '"  required>' . $label . '</label>
        <input type="' . $type . '" name="' . $key . '" id="field' . $key . '" />
      </div>';
  }
}
