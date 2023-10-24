<?php

namespace App\Exceptions;

use App\Facades\Response;
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
        AuthFailedException::class,
        BadRequestException::class,
        ForbiddenAccessException::class,
        NotFoundException::class,
        UnauthorizedException::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if (in_array(get_class($e), $this->customExceptions)) {
            return $e->render();
        } else {
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
            return Response::message($e->getMessage())->status($statusCode)->send();
        }
    }
}
