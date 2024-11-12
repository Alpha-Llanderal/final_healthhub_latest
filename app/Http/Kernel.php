<?php

protected $routeMiddleware = [
    // Other middlewares...
    'user.active' => \App\Http\Middleware\EnsureUserIsActive::class,
];