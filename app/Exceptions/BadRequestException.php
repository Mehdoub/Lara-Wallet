<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class BadRequestException extends CustomException
{
    protected $message = 'bad_request';
    protected $errors = [];

    public function __construct(string $message = '', array $errors = [])
    {
        $this->message = strlen($message) > 0 ? $message : $this->message;
        $this->errors = count($errors) > 0 ? $errors : $this->errors;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function status(): string
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
