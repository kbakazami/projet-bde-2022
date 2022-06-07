<?php

namespace App\Utils;

class Form
{

  private $errors;

  public function __construct(array $errors)
  {
    $this->errors = $errors;
  }

  public function input(string $key, string $label, string $type, string $valuePlaceholder)
  {

    return
      '<div>
        <label class="labelFront" for="field' . $key . '" >' . $label . '</label>
        <input class="inputFront" required type="' . $type . '" name="' . $key . '" id="field' . $key . '" placeholder="' . $valuePlaceholder . '" />
      </div>';
  }
}
