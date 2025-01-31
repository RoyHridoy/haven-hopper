<?php

namespace App\Filament\Resources;

use App\Enums\BookingPaymentStatus;
use App\Enums\BookingStatus;
use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

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
                    ->sortable()
                    ->label('Rental Name'),
                TextColumn::make('check_in_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('check_out_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('total_guests')
                    ->sortable()
                    ->label('Guests'),
                TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (BookingStatus $state) => match ($state) {
                        BookingStatus::APPROVED => 'success',
                        BookingStatus::PENDING => 'warning',
                        BookingStatus::REJECTED => 'gray',
                        BookingStatus::CANCELLED => 'danger',
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->defaultSort('check_in_date', 'asc')
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
                Action::make('approve')
                    ->visible(fn (Booking $booking) => $booking->status === BookingStatus::PENDING)
                    ->before(function (Booking $booking) {

                        $checkInDate = Carbon::parse($booking->check_in_date);
                        $checkOutDate = Carbon::parse($booking->check_out_date);

                        $overlapExists = Booking::where('rental_id', $booking->rental_id)
                            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                                $query->overlap($checkInDate, $checkOutDate)->approved();
                            })->exists();

                        if ($overlapExists) {
                            Notification::make()
                                ->title('Booking Conflict')
                                ->body('This rental is already booked for the selected dates.')
                                ->danger()
                                ->send();
                            throw ValidationException::withMessages([
                                'rental is already booked for the selected dates',
                            ]);
                        }
                    })
                    ->requiresConfirmation()
                    ->action(function (Booking $booking) {
                        $booking->update([
                            'status' => BookingStatus::APPROVED,
                        ]);
                    }),
                Action::make('reject')
                    ->visible(fn (Booking $record) => $record->status === BookingStatus::PENDING)
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
