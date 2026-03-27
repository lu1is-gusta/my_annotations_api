<?php 

namespace App\DTO;

use Exception;

class ResponseLoginDataUserDTO
{
    protected $token;
    protected $user_data;

    public function __construct(string $token, ?array $user_data = [])
    {
        $this->token = $token;
        $this->user_data = $user_data;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}