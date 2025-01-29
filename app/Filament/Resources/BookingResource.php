<?php

namespace App\Filament\Resources;

use App\Enums\BookingPaymentStatus;
use App\Enums\BookingStatus;
use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('total_guests')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('tax')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('convenience_fee')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                Select::make('status')
                    ->required()
                    ->options(BookingStatus::class)
                    ->label('Approval Status'),
                TextInput::make('payment_status')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rental.title')
                    ->words(4)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('check_in_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('check_out_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('total_guests')
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (BookingStatus $state) => match ($state) {
                        BookingStatus::APPROVED => 'success',
                        BookingStatus::PENDING => 'warning',
                        BookingStatus::REJECTED => 'danger',
                        BookingStatus::CANCELLED => 'warning',
                        BookingStatus::COMPLETED => 'info',
                    }),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('discount')
                    ->money()
                    ->sortable(),
                TextColumn::make('tax')
                    ->money()
                    ->sortable(),
                TextColumn::make('total_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('convenience_fee')
                    ->money()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('payment_status')
                    ->sortable()
                    ->badge()
                    ->color(fn (BookingPaymentStatus $state) => match ($state) {
                        BookingPaymentStatus::PAID => 'success',
                        BookingPaymentStatus::PENDING => 'warning',
                        BookingPaymentStatus::FAILED => 'danger',
                    }),
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->visible(fn () => self::isAvailable()),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                MultiSelectFilter::make('payment_status')
                    ->options(BookingPaymentStatus::class),
                MultiSelectFilter::make('status')
                    ->options(BookingStatus::class)
                    ->label('Approve Status'),
            ])
            ->actions([
                EditAction::make()
                    ->visible(fn () => self::isAvailable()),
                /** TODO:
                 * Approve and reject button only available on want to book page
                 * When approve booking, validate checkInDate and checkOutDate that slot is available or not
                 * Add Image for rental
                 * total price calculate
                 * write validation for amenities and locations
                 */
                Action::make('approve')
                    ->requiresConfirmation()
                    ->action(function (Booking $booking) {
                        $booking->update([
                            'status' => BookingStatus::APPROVED,
                            'payment_status' => BookingPaymentStatus::PAID,
                        ]);
                    }),
                Action::make('reject')
                    ->requiresConfirmation()
                    ->action(function (Booking $booking) {
                        $booking->update([
                            'status' => BookingStatus::REJECTED,
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                if (filament()->getCurrentPanel()->getId() === 'host') {
                    $query->whereHas('rental', function ($query) {
                        $query->where('owner_id', auth()->id());
                    });
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
            'index' => Pages\ListBookings::route('/'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public static function isAvailable(): bool
    {
        return filament()->getCurrentPanel()->getId() === 'admin';
    }
}
