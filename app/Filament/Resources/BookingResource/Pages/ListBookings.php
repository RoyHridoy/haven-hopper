<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Enums\BookingStatus;
use App\Filament\Resources\BookingResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'want_to_book' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', BookingStatus::PENDING))
                ->icon('heroicon-o-calendar-date-range')
                ->label('Booking Requests'),
        ];
    }
}
