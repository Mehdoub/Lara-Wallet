<?php

namespace App\Exceptions;

use App\Facades\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        if ($e instanceof ModelNotFoundException) {
            throw new NotFoundException();
        }
        if ($e instanceof AuthenticationException) {
            throw new UnauthorizedException();
        }

        if (in_array(get_class($e), $this->customExceptions)) {
            return $e->render();
        } else {
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
            return Response::message($e->getMessage())->status($statusCode)->send();
        }
    }
}
