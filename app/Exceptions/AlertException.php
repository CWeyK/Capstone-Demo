<?php

namespace App\Exceptions;

use Exception;

class AlertException extends Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;

        parent::__construct();
    }

    public function __toString(): string
    {
        return "Livewire Alert Exception: {$this->message}";
    }
}
