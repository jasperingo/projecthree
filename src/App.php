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
]);

$app = Bridge::create($containerBuilder->build());

$app->group('', IndexRoute::class);

$app->group('/users', UsersRoute::class);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$errorMiddleware->setDefaultErrorHandler(ErrorHandler::class);

$app->run();
