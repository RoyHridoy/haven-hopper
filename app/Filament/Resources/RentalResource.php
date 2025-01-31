<?php

namespace App\Filament\Resources;

use App\Enums\RentalApprovalStatus;
use App\Enums\RentalType;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Filament\Resources\RentalResource\Pages;
use App\Models\Rental;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class RentalResource extends Resource
{
    protected static ?string $model = Rental::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        $panel = filament()->getCurrentPanel();
        $rentalOwnerId = $panel->getId() === 'host' ? auth()->id() : null;

        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Rental title'),
                Select::make('rental_type')
                    ->required()
                    ->options(RentalType::class)
                    ->rules([Rule::enum(RentalType::class)])
                    ->native(false),
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
                    ->exists('amenities', 'id')
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('location_id')
                    ->relationship('location', 'city')
                    ->required()
                    ->exists('locations', 'id')
                    ->native(false),
                FileUpload::make('images')
                    ->label('Rental Images')
                    ->multiple()
                    ->directory('rentals')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '4:3',
                        '16:9',
                    ])
                    ->maxFiles(4)
                    ->maxSize(1024)
                    ->imagePreviewHeight('250')
                    ->panelLayout('grid')
                    ->reorderable(),
                Textarea::make('description')
                    ->nullable()
                    ->string()
                    ->columnSpanFull(),
                Select::make('approval_status')
                    ->required()
                    ->options(RentalApprovalStatus::class)
                    ->default(RentalApprovalStatus::PENDING)
                    ->rules([Rule::enum(RentalApprovalStatus::class)])
                    ->visible($panel->getId() === 'admin'),
                Select::make('owner_id')
                    ->relationship(
                        'owner',
                        'name',
                        function ($query) {
                            $query->where('role', UserRole::RENTAL_OWNER)->where('status', UserStatus::ACTIVE);
                            if (auth()->user()->role === UserRole::RENTAL_OWNER) {
                                return $query->where('id', auth()->id());
                            }

                            return $query;
                        }
                    )
                    ->default($rentalOwnerId)
                    ->required()
                    ->rules([
                        Rule::exists('users', 'id')->where('role', UserRole::RENTAL_OWNER),
                    ])
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        $panel = filament()->getCurrentPanel();

        return $table
            ->columns([
                TextColumn::make('title')->words(4)
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
                        RentalApprovalStatus::PENDING => 'warning',
                        RentalApprovalStatus::REJECTED => 'danger',
                    }),
                TextColumn::make('owner.name')
                    ->numeric()
                    ->sortable()
                    ->visible($panel->getId() === 'admin'),
                TextColumn::make('location.city')
                    ->numeric()
                    ->label('City')
                    ->sortable(),
                TextColumn::make('location.country')
                    ->numeric()
                    ->label('Country')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('amenities.name')
                    ->separator(', ')
                    ->color('info'),
                TextColumn::make('check_in_time')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('check_out_time')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('guest_on_requests')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('extra_guests_charge')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                MultiSelectFilter::make('type')
                    ->options(RentalType::class)
                    ->label('Rental Type'),
                MultiSelectFilter::make('approval_status')
                    ->options(RentalApprovalStatus::class)
                    ->label('Approval Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) use ($panel) {
                if ($panel->getId() === 'host') {
                    $query->where('owner_id', auth()->id());
                }

                return $query;
            });
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
