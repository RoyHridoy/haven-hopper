<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()->role === UserRole::ADMIN;
    }
}
