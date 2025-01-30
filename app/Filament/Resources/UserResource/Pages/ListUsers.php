<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'want_to_host' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('want_to_host', true))
                ->icon('heroicon-o-users')
                ->badge(User::query()->where('want_to_host', true)->count()),
        ];
    }
}
