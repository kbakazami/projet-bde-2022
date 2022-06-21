<?php

namespace App\Config;

use App\Utils\FormExtension;
use App\Utils\ValdiationAccess;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigEnvironment
{

  public function init(): Environment
  {
    $loader = new FilesystemLoader(__DIR__ . '/../../templates');
      $twig =  new Environment($loader, [
        'debug' => $_ENV['APP_ENV'] === 'dev',
        'cache' => __DIR__ . '/../../var/cache',
        'debug' => true,
      ]);
      $form = new FormExtension();
      $acces = new ValdiationAccess();
      $twig->addExtension($form);
      $twig->addExtension($acces);
      return $twig;
  }

}
