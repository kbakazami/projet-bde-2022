<?php

namespace App\Utils;

class ValidationError {
    private $key;
    private $rule;
    private  $attributes;

    private $messages = [
        'required' => 'Le champ %s requis',
        'empty' => 'Le champ %s ne doit pas être vide',
        'minLength' => 'Le champ %s ne doit pas être vide',
        'maxLength' => 'Le champ %s doit contenir moins de %d caractères',
        'betweenLength' => 'Le champ %s doit contenir entre %d et %d caractères',
        'dateTime' => 'Veuillez sélectionner une date',
        'mailPattern' => 'Ne sont acccepté que les emails @myges.fr valide',
        'confirmPassword' => 'Les mots de passes sont différents',
        "select" => "Veuillez choisir une valeur"
    ];

    public function __construct(string $key, string $rule, array $attributes= []) {
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }

    public function __toString() {
        $params= array_merge([$this->messages[$this->rule], $this->key], $this->attributes);
        return (string)call_user_func_array('sprintf', $params);
    }
}