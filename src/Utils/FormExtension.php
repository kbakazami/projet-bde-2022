<?php

namespace App\Utils;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

class FormExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction("field", [$this, 'field'], [
                'is_safe' => ['html'],
                'needs_context' => true
            ])
        ];
    }

    public function field(array $context, string $key, string $label, $value ='', array $options = [])
    {

        $type = $options["type"] ?? 'text';
        $error = $this->getErrorHtml($context, $key);
        $class = 'form-group';
        $attributes = [
            'class' => 'form-control',
            'id' => $key,
            'name' => $key
        ];

        if($error){
            $class .= ' text-red';
            $attributes['class'] .= ' form-control-danger';
        }

        if($type === 'textarea'){
            $input = $this->textarea($value, $attributes);
        }else{
            $input = $this->input($value, $attributes, $type);
        }

        echo '<div class="' .  $class .'">
        <label for="field"' . $key . '>' . $label . '</label>'
        . $input . $error .
      '</div>';
    }

    private function getErrorHtml($context, $key)
    {
        $error = $context["errors"][$key] ?? false;
        $errorHTML = "";
        if($error){
            return "<small>{$error}</small>";
        }
        return "";
    }

    private function input(?string $value, array $attributes, $type): string
    {
        return'<input type="'. $type .'"'. $this->getHtmlFromArray($attributes) . ' value="' . $value . '" />';
    }

    private function textarea(?string $value, array $attributes): string
    {
        return '<textarea type="text" '. $this->getHtmlFromArray($attributes) .'>' . $value .'</textarea>';
    }

    private function getHtmlFromArray(array $attributes) {
        return implode(' ', array_map(function ($key, $value){
            return "$key=\"$value\"";
        }, array_keys($attributes), $attributes));
    }

}