<?php

protected $routeMiddleware = [
'password.check' => \App\Http\Middleware\CheckPasswordReset::class,
'auth' => \App\Http\Middleware\Authenticate::class,
];