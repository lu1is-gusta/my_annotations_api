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
    protected $previous;

    public function __construct(Exception $exception)
    {
        $this->error = true;
        $this->message = $exception->getMessage();
        $this->code = $exception->getCode();
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
        $this->previous = $exception->getPrevious();
        $this->stackTrace = $exception->getTraceAsString();
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function basicInformationException(): object
    {
        $data = ['error' => $this->error, 'message' => $this->message];

        return (object) $data;
    }
}