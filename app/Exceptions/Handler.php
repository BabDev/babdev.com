<?php

namespace BabDev\Exceptions;

use BabDev\Contracts\Services\Exceptions\PageNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->map(
            PageNotFoundException::class,
            static fn (PageNotFoundException $e): NotFoundHttpException => new NotFoundHttpException($e->getMessage(), $e),
        );
    }
}
