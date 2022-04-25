<?php

namespace App\Config;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class TwigEnvironment
{
  public function init(): Environment
  {
    $loader = new FilesystemLoader(__DIR__ . '/../../templates');
    return new Environment($loader, [
      'debug' => $_ENV['APP_ENV'] === 'dev',
      'cache' => __DIR__ . '/../../var/cache',
      'debug' => true,
    ]);
    
  }
}
