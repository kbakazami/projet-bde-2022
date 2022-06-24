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

    public function field(array $context, string $key, string $label, string $placeholder, $value ='', array $options = [])
    {

        $type = $options["type"] ?? 'text';
        $data = $options["data"] ?? null;
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
            $input = $this->textarea($value, $attributes, $placeholder);
        }elseif ($type === 'select'){
            $input = $this->select($value, $attributes, $data);
        }
//        elseif ($type === 'file')
//        {
//            $input = $this->file($value, $attributes, $type, $jsMethod);
//        }
        else{
            $input = $this->input($value, $attributes, $type, $placeholder);
        }

        echo '<div class="' .  $class .'">
        <label for="field"' . $key . '>' . $label . '</label>'
        . $input . $error .
      '</div>';
    }


    private function getErrorHtml($context, $key)
    {
        $error = $context["errors"][$key] ?? false;
        if($error){
            return "<small>{$error}</small>";
        }
        return "";
    }

    private function input(?string $value, array $attributes, $type, ?string $placeholder): string
    {
        return'<input type="'. $type .'"'. $this->getHtmlFromArray($attributes) . ' value="' . $value . '" placeholder="'. $placeholder .'" />';
    }

    private function textarea(?string $value, array $attributes, ?string $placeholder): string
    {
        return '<textarea type="text" placeholder="'. $placeholder .'"'. $this->getHtmlFromArray($attributes) .'>' . $value .'</textarea>';
    }

    private function select(?string $value, array $attributes, $data): string
    {

        $select = "<select {$this->getHtmlFromArray($attributes)}>";
        
        if($value !== ''){
            foreach ($data as $key => $val) {
                $select .= "<option value='{$val->id}' " . ($value === $val->id ? "selected" : "") . ">$val->title</option>";
            }
        }else{
            $select .= "<option>Sélectionnez une valeur</option>";

            foreach ($data as $d){

                $select .= "<option value='$d->id'>$d->title</option>";
            }
        }

        $select .= "</select>";
        return $select;
    }


    private function getHtmlFromArray(array $attributes) {
        return implode(' ', array_map(function ($key, $value){
            return "$key=\"$value\"";
        }, array_keys($attributes), $attributes));
    }

}