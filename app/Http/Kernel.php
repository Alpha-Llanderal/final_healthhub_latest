<?php

protected $routeMiddleware = [
    'user.active' => \App\Http\Middleware\EnsureUserIsActive::class,
    'ensure.active' => \App\Http\Middleware\EnsureUserIsActive::class,
];