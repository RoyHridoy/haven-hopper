<?php

namespace App\Filament\Resources;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->string(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('password_confirmation')
                    ->password()
                    ->required()
                    ->same('password')
                    ->label('Confirm Password'),
                TextInput::make('phone')
                    ->tel()
                    ->nullable(),
                Select::make('role')
                    ->options(UserRole::class)
                    ->label('Role'),
                Select::make('status')
                    ->options(UserStatus::class)
                    ->label('Status')
                    ->default(UserStatus::ACTIVE),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('role')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                Action::make('makeHost')
                    ->requiresConfirmation()
                    ->visible(fn (User $record) => $record->want_to_host)
                    ->action(function (User $user) {
                        $user->update([
                            'role' => UserRole::RENTAL_OWNER,
                            'want_to_host' => false,
                        ]);
                    }),
                Action::make('reject')
                    ->requiresConfirmation()
                    ->visible(fn (User $record) => $record->want_to_host)
                    ->action(function (User $user) {
                        $user->update([
                            'want_to_host' => false,
                        ]);
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('want_to_host', true)->count();
    }
}
