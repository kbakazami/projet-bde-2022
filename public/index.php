<?php

// Inclut l'autoloader généré par Composer
require_once __DIR__ . "/../vendor/autoload.php";

if (
  php_sapi_name() !== 'cli' &&
  preg_match('/\.(?:png|jpg|jpeg|gif|ico|css|js|ttf)$/', $_SERVER['REQUEST_URI'])
) {
  return false;
}

use App\Config\PdoConnection;
use App\Config\TwigEnvironment;
use App\DependencyInjection\Container;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\NewsRepository;
use App\Routing\ArgumentResolver;
use App\Routing\RouteNotFoundException;
use App\Routing\Router;
use App\Session\Session;
use App\Session\SessionInterface;
use App\Utils\FormExtension;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;

// On définit une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

// Env vars - Possibilité d'utiliser le pattern Adapter
// Pour pouvoir varier les dépendances qu'on utilise
$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

// PDO
$pdoConnection = new PdoConnection();
$pdoConnection->init(); // Connexion à la BDD
$userRepository = new UserRepository($pdoConnection->getPdoConnection());
$categoryRepository = new CategoryRepository($pdoConnection->getPdoConnection());
$eventRepository = new EventRepository($pdoConnection->getPdoConnection());
$roleRepository = new RoleRepository($pdoConnection->getPdoConnection());
$newsRepository = new NewsRepository($pdoConnection->getPdoConnection());

// Twig - Vue
$twigEnvironment = new TwigEnvironment();
$twig = $twigEnvironment->init();
$formTwig = new FormExtension();

// Service Container
$container = new Container();
$container->set(Environment::class, $twig);
$container->set(SessionInterface::class, new Session());
$container->set(UserRepository::class, $userRepository);
$container->set(CategoryRepository::class,$categoryRepository);
$container->set(EventRepository::class, $eventRepository);
$container->set(RoleRepository::class, $roleRepository);
$container->set(FormExtension::class, $formTwig);
$container->set(NewsRepository::class, $newsRepository);

// Routage
$router = new Router($container, new ArgumentResolver());
$router->registerRoutes();

if (php_sapi_name() === 'cli') {
  return;
}

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

try {
  $router->execute($requestUri, $requestMethod);
} catch (RouteNotFoundException $e) {
  http_response_code(404);
  echo $twig->render('404.html.twig', ['title' => $e->getMessage()]);
}
