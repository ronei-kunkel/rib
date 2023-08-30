<?php declare(strict_types=1);

/**
 * @see bootstrap/boot/routes.php
 * @see HttpSoft\Basis\Application
 * @see HttpSoft\Router\RouteCollector
 */

use HttpSoft\Router\RouteCollector;
use Rib\Http\Action\Post\ListAction;
use Rib\Http\Action\Post\ViewAction;

$route->get('/', '/?', Rib\Http\Action\HomeAction::class);

$route->group('/user', static function (RouteCollector $router) {
  $router->get('user.list', '', ListAction::class);
  $router->get('user.view', '/{id}', ViewAction::class)->tokens(['id' => '\d+']);
});