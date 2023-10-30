<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class UnauthorizedException extends CustomException
{
    protected $message = null;
    protected $errors = [];

    public function __construct(string $message = '', array $errors = [])
    {
        $this->message = strlen($message) > 0 ? $message : $this->message;
        $this->errors = count($errors) > 0 ? $errors : $this->errors;
    }

    public function message(): string
    {
        return $this->message ?: __('auth.errors.unauthorized');
    }

    public function status(): string
    {
        return Response::HTTP_UNAUTHORIZED;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
