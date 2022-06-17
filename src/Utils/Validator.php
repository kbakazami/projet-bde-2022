<?php

namespace App\Utils;

class Validator
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var string []
     */
    private $errors = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Vérifie que les champs sont présents dans le tableau
     * @param string[] ...$key
     * @return Validator
     */
    public function required(string ...$keys): self{
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
               $this->addError($key, 'required');
            }
        }
        return $this;
    }

    /**
     * Vérifie que les champs ne sont pas vides
     * @param string[] ...$keys
     * @return Validator
     */
    public function notEmpty(string ...$keys): self{
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value) || empty($value)) {
               $this->addError($key, 'empty');
            }
        }
        return $this;
    }

    public function mailPattern(string $key):self
    {
        $pattern = '/@+myges+\.fr+$/';

        if(!preg_match($pattern, $this->params[$key])){
            $this->addError($key, 'mailPattern');
        }
        return $this;
    }

    public function confirmPasword(string $key, string $confirmPass):self
    {
        $value = $this->getValue($key);
        $value2 = $this->getValue($confirmPass);

        if($value !== $value2){
            $this->addError($key, 'confirmPassword');
        }
        return $this;
    }

    public function length(string $key, ?int $min, ?int $max = null): self
    {
        $value = $this->getValue($key);
        $length = strlen($value);
        if (!is_null($min) &&
            !is_null($max) &&
            ($length < $min || $length > $max)
        ) {
            $this->addError($key, 'betweenLength', [$min, $max]);
            return $this;
        }

        if(!is_null($min) &&
            $length < $min
        ){
            $this->addError($key, 'minLength', [$min]);
            return $this;
        }

        if(!is_null($max) &&
            $length > $max
        ){
            $this->addError($key, 'maxLength', [$max]);
        }
        return $this;
    }

    public function dateTime(string $key):self
    {
        $value = $this->getValue($key);

        if($value === ""){
            $this->addError($key, 'dateTime');
        }
        return $this;
    }

    public function select(string $key){
        $value = $this->getValue($key);

        if($value === "Sélectionnez une valeur"){
            $this->addError($key, 'select');
        }
        return $this;
    }

    public function isValid():bool
    {
        return empty($this->errors);
    }

    /**
     * Récupère les erreurs
     * @return ValidationError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Ajoute une erreur
     * @param string $key
     * @param string $rule
     * @param array $attributes
     */
    private function addError(string $key, string $rule, array $attributes = []): void
    {
        $this->errors[$key] = new ValidationError($key, $rule, $attributes);
    }

    private function getValue(string $key){

        if(array_key_exists($key, $this->params)){
            return $this->params[$key];
        }
        return null;
    }
}