<?php 

namespace App\DTO;

use Exception;

class ExceptionResponseDTO
{
    protected $message;
    protected $error;
    protected $code;
    protected $file;
    protected $line;
    protected $stackTrace;

    public function __construct(Exception $exception)
    {

    }

    public function toArray(){
        return get_object_vars($this);
    }
}