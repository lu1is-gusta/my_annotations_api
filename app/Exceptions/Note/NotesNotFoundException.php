<?php

namespace App\Exceptions;

use Exception;

class NotesNotFoundException extends Exception 
{

    public function __construct(\Throwable $previous = null)
    {
        return parent::__construct("Notes not found", 404, $previous);
    }
}