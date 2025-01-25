<?php

namespace App\DTO;

use Illuminate\Support\Facades\Validator;

abstract class BaseDTO
{
    /**
     * The validated data.
     *
     * @var array<string, string>
     */
    protected array $data = [];

    /**
     * Defines the validation rules for the DTO.
     *
     * @return array<string, mixed>
     */
    abstract protected function fields(): array;

    /**
     * @param  array <string, mixed>  $data
     */
    final public function __construct(array $data)
    {
        $this->data = $this->validated($data);
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function createFromArray(array $data): static
    {
        return static::factory($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function validate(array $data): static
    {
        return static::factory($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function factory(array $data): static
    {
        return new static($data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function validated(array $data): array
    {
        return Validator::make($data, $this->fields())->validated();
    }
}
