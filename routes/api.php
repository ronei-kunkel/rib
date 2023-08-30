<?php declare(strict_types=1);

/**
 * @see bootstrap/boot/routes.php
 * @see HttpSoft\Basis\Application
 * @see HttpSoft\Router\RouteCollector
 */

use HttpSoft\Router\RouteCollector;
use Rib\Http\Action\Post\ListAction;
use Rib\Http\Action\Post\ViewAction;

$route->group('/v1', static function (RouteCollector $router) {
  $router->get('api.v1', '/?', ListAction::class);
  $router->get('api.v1.resource', '/{id}', ViewAction::class)->tokens(['id' => '\d+']);
});

