<?php

namespace BabDev\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
}
