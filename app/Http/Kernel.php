<?php

protected $routeMiddleware = [
'password.check' => \App\Http\Middleware\CheckPasswordReset::class,
];