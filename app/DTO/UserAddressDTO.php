<?php

namespace App\DTO;

class UserAddressDTO extends BaseDTO
{
    /**
     * @return array{address_line_one: string[], address_line_two: string[], city: string[], country: string[], state: string[]}
     */
    protected function fields(): array
    {
        return [
            'country' => ['required', 'string', 'min:3', 'max:20'],
            'city' => ['required', 'string', 'min:3', 'max:20'],
            'state' => ['required', 'string', 'min:3', 'max:20'],
            'address_line_one' => ['required', 'string', 'min:5', 'max:255'],
            'address_line_two' => ['nullable', 'string', 'min:5', 'max:255'],
        ];
    }
}
