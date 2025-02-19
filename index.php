<?php

require 'vendor/autoload.php';

use App\Router;
use App\Controllers\User;
use App\Controllers\Book;
use App\Controllers\Author;
use App\Controllers\Borrow;
use App\Controllers\Auth;
use App\Utils\Route;

$router = new Router();

$controllers = [User::class, Book::class, Author::class, Borrow::class, Auth::class];

// We scan the controllers for attributes and register the routes
foreach ($controllers as $controller) {
    $reflection = new \ReflectionClass($controller);
    foreach ($reflection->getMethods() as $method) {
        $attributes = $method->getAttributes(Route::class);
        foreach ($attributes as $attribute) {
            $instance = $attribute->newInstance();
            $router->register($instance->method, $instance->path, $controller, $method->getName());
        }
    }
}

$router->run();