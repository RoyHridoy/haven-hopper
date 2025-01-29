<?php

namespace App\Filament\Resources;

use App\Enums\RentalApprovalStatus;
use App\Enums\RentalType;
use App\Filament\Resources\RentalResource\Pages;
use App\Models\Rental;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RentalResource extends Resource
{
    protected static ?string $model = Rental::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),
                Select::make('rental_type')
                    ->required()
                    ->options(RentalType::class),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('total_guests')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('guest_on_requests')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('extra_guests_charge')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                Select::make('amenities')
                    ->relationship('amenities', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('approval_status')
                    ->required()
                    ->options(RentalApprovalStatus::class)
                    ->default(RentalApprovalStatus::PENDING),
                Select::make('owner_id')
                    ->relationship('owner', 'name')
                    ->required(),
                Select::make('location_id')
                    ->relationship('location', 'city')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('rental_type')
                    ->searchable(),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('total_guests')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('approval_status')
                    ->searchable()
                    ->badge()
                    ->color(fn (RentalApprovalStatus $state) => match ($state) {
                        RentalApprovalStatus::APPROVED => 'success',
                        RentalApprovalStatus::PENDING => '',
                        RentalApprovalStatus::REJECTED => 'danger',
                    }),
                TextColumn::make('owner.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('location.city')
                    ->numeric()
                    ->label('City')
                    ->sortable(),
                TextColumn::make('location.country')
                    ->numeric()
                    ->label('Country')
                    ->sortable(),
                TextColumn::make('amenities.name')
                    ->badge()
                    ->separator(', ')
                    ->color('info'),

                TextColumn::make('check_in_time'),
                TextColumn::make('check_out_time'),
                TextColumn::make('guest_on_requests')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('extra_guests_charge')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentals::route('/'),
            'create' => Pages\CreateRental::route('/create'),
            'edit' => Pages\EditRental::route('/{record}/edit'),
        ];
    }
}
