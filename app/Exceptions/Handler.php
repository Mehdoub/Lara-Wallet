<?php

namespace App\Exceptions;

use App\Facades\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    private $customExceptions = [
        BadRequestException::class,
        ForbiddenAccessException::class,
        NotFoundException::class,
        UnauthorizedException::class,
    ];

    private $customErrors = [
        ModelNotFoundException::class => NotFoundException::class,
        AuthenticationException::class => UnauthorizedException::class,
        RouteNotFoundException::class => UnauthorizedException::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }

    public function render($request, Throwable $e)
    {
        $exceptionClass = get_class($e);
        if (in_array($exceptionClass, array_keys($this->customErrors))) {
            throw new $this->customErrors[$exceptionClass]();
        }

        if (in_array($exceptionClass, $this->customExceptions)) {
            return $e->render();
        } else {
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
            return Response::message($e->getMessage())->status($statusCode)->send();
        }
    }
}
