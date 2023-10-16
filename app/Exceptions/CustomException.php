<?php

namespace App\Exceptions;

use App\Facades\Response;
use Exception;

abstract class CustomException extends Exception
{
    public function __construct()
    {
        parent::__construct($this->message(), $this->status());
    }

    abstract public function status(): string;

    abstract public function message(): string;

    abstract public function errors(): array;

    private function getErrorMessage(): string
    {
        return __('exceptions.' . $this->message());
    }

    public function render()
    {
        return Response::message($this->getErrorMessage())
            ->status($this->status())
            ->errors($this->errors())
            ->send();
    }

    public function report()
    {
        return false;
    }
}
