<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        /** @var array<int, array{
         * name: string,
         * number: string,
         * code: string,
         * currency: string,
         * flag_code: string,
         * continent: string,
         * capital: string,
         * }> $countryConfig
         */
        $countryConfig = config('country', []);

        $supportedCountries = collect($countryConfig)
            ->map(function (array $country): array {
                return [
                    $country['code'] => $country['name'],
                ];
            });

        return $form
            ->schema([
                Forms\Components\Select::make('country')
                    ->searchable()
                    ->options($supportedCountries),
                Forms\Components\Select::make('city')
                    ->searchable()
                    // list of cities based on country selection
                    ->options(function (\Illuminate\Http\Request $request) {
                        $country = $request->get('country');

                        /** @var array<int, array{
                         * name: string,
                         * timezone: string,
                         * country: string,
                         * country_code: string
                         * }> $citiesConfig
                         */
                        $citiesConfig = config('cities', []);

                        $cities = collect($citiesConfig)
                            ->where('country_code', $country)
                            ->map(function (array $city): string {
                                return $city['name'];
                            });

                        return collect($cities)->map(function ($city) {
                            return [
                                $city => $city,
                            ];
                        });
                    }),
                Forms\Components\TextInput::make('city')
                    ->required(),
                Forms\Components\TextInput::make('state')
                    ->required(),
                Forms\Components\TextInput::make('latitude'),
                Forms\Components\TextInput::make('longitude'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable(),
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
