<?php

namespace App\DTO;

use Illuminate\Support\Facades\Validator;

abstract class BaseDTO
{
    protected array $data = [];

    abstract protected function fields(): array;

    public function __construct(array $data)
    {
        $this->data = $this->validated($data);
    }

    public static function createFromArray(array $data): static
    {
        return new static($data);
    }

    private function validated(array $data)
    {
        return Validator::make($data, $this->fields())->validated();
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
