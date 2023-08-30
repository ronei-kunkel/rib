<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @requires config/app.php
 * @requires config/container.php
 * @requires bootstrap/boot/pipeline.php
 * @requires bootstrap/boot/routes.php
 */

use HttpSoft\Basis\Application;
use HttpSoft\ServerRequest\ServerRequestCreator;
use Devanych\Di\Container;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->safeLoad();

$appConfig['config'] = require_once __DIR__ . '/../config/app.php';
$container           = require_once __DIR__ . '/../config/container.php';

$container = new Container($appConfig + $container);

$app = $container->get(Application::class);

require_once __DIR__ . '/boot/pipeline.php';

require_once __DIR__ . '/boot/routes.php';

$app->run(ServerRequestCreator::create(), null);