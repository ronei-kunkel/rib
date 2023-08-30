<?php declare(strict_types=1);

/**
 * @see bootstrap/app.php
 * @see https://httpsoft.org/docs/app/v1/dependency-injection
 */

use Factory\ApplicationFactory;
use Factory\ErrorHandlerMiddlewareFactory;
use Factory\LoggerFactory;
use HttpSoft\Basis\Application;
use HttpSoft\Basis\Response\CustomResponseFactory;
use HttpSoft\Cookie\CookieManager;
use HttpSoft\Cookie\CookieManagerInterface;
use HttpSoft\Emitter\SapiEmitter;
use HttpSoft\Emitter\EmitterInterface;
use HttpSoft\ErrorHandler\ErrorHandlerMiddleware;
use HttpSoft\Router\RouteCollector;
use HttpSoft\Runner\MiddlewarePipeline;
use HttpSoft\Runner\MiddlewarePipelineInterface;
use HttpSoft\Runner\MiddlewareResolver;
use HttpSoft\Runner\MiddlewareResolverInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Predis\Client;
use PhpAmqpLib\Connection\AMQPStreamConnection;


return [

    Application::class                 => new ApplicationFactory(),
    EmitterInterface::class            => new SapiEmitter(),
    RouteCollector::class              => new RouteCollector(),
    MiddlewarePipelineInterface::class => new MiddlewarePipeline(),
    MiddlewareResolverInterface::class => fn(ContainerInterface $c) => new MiddlewareResolver($c),
    CookieManagerInterface::class      => new CookieManager(),
    ErrorHandlerMiddleware::class      => new ErrorHandlerMiddlewareFactory(),
    ResponseFactoryInterface::class    => new CustomResponseFactory(),
    LoggerInterface::class             => new LoggerFactory(),
    Cache::class                       => fn (ContainerInterface $c) => new Client($c->get('cache')),
    Database::class                    => fn(ContainerInterface $c) => new PDO($c->get('database')),
    Queue::class                       => fn(ContainerInterface $c) => new AMQPStreamConnection(...$c->get('queue'))

];