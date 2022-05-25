<?php
use Dotenv\Dotenv;
use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Slim\Views\PhpRenderer;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\JsonFileLoader;
use Jasper\Projecthree\Errors\ErrorHandler;
use Jasper\Projecthree\Routes\IndexRoute;
use Jasper\Projecthree\Routes\UsersRoute;
use Psr\Container\ContainerInterface;
use Aura\Session\SessionFactory;
use Aura\Session\Segment as SessionSegment;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
  Translator::class => function() {
    $translator = new Translator('en');
    $translator->setFallbackLocales(['en']);
    $translator->addLoader('json', new JsonFileLoader());
    $translator->addResource('json', __DIR__.'/assets/strings/en.json', 'en');
    return $translator;
  },

  'icons' => fn() => 
    json_decode(file_get_contents(__DIR__.'/assets/icons/icons.json'), true),

  PhpRenderer::class => fn(ContainerInterface $container, Translator $translator) => 
    new PhpRenderer(__DIR__.'/views', [
      '__' => $translator->trans(...),
      'icons' => $container->get('icons')
    ]),
  
  SessionSegment::class => function() {
    $sessionFactory = new SessionFactory;
    $session = $sessionFactory->newInstance($_COOKIE);
    return $session->getSegment('Jasper\\Projecthree');
  },

  EntityManager::class => function() {
    $cache = $_ENV['PHP_ENV'] === 'development' 
      ? DoctrineProvider::wrap(new ArrayAdapter()) 
      : DoctrineProvider::wrap(new FilesystemAdapter(directory: __DIR__.'/cache/doctrine'));

    $config = Setup::createAttributeMetadataConfiguration(
        [__DIR__.'/Models'],
        $_ENV['PHP_ENV'] === 'development',
        cache: $cache
    );

    return EntityManager::create([
      'host'     => $_ENV['DB_HOST'],
      'driver'   => $_ENV['DB_DRIVER'],
      'user'     => $_ENV['DB_USERNAME'],
      'password' => $_ENV['DB_PASSWORD'],
      'dbname'   => $_ENV['DB_DATABASE'],
    ], $config);
  }
]);

$app = Bridge::create($containerBuilder->build());

$app->group('', IndexRoute::class);

$app->group('/users', UsersRoute::class);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$errorMiddleware->setDefaultErrorHandler(ErrorHandler::class);

$app->run();
