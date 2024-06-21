<?php

namespace App\Filament\Resources\UserResource;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use function Laravel\Prompts\warning;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 0;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return 'Listar ' . __('users');
    }

    public static function getNavigationGroup(): string
    {
        return __('User Management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn ($operation): bool => $operation === 'create')
                    ->dehydrated(fn (?string $state) => filled($state))
                    ->confirmed(),
                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->requiredWith('password')
                    ->dehydrated(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\ToggleColumn::make('active')->label('Status'),
            ])
            ->filters([
                SelectFilter::make('active')
                    ->multiple()
                    ->options([
                        true => 'Ativo',
                        false => 'Inativo',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Desativar selecionado')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->icon('heroicon-o-lock-closed')
                        ->action(function (Collection $users) {
                            if ($users->count() > 20) {
                                Notification::make()
                                    ->title('Realize a operação com no máximo 20 itens')
                                    ->warning()
                                    ->send();
                                return false;
                            } else {
                                Notification::make()
                                    ->title('Desativado com sucesso')
                                    ->success()
                                    ->send();

                                $users->each->update(['active' => false]);
                            }
                        }),
                    // ->after(fn () =>
                    //         Notification::make()
                    //         ->title('Desativado com sucesso')
                    //         ->success()
                    //         ->send()
                    // ),
                    // Tables\Actions\BulkAction::make('Ativar')
                    //     ->color('warning')
                    //     ->requiresConfirmation()
                    //     ->icon('heroicon-o-lock-open')
                    //     ->action(function (Collection $users){
                    //         if ($users->count() > 20) {
                    //             Notification::make()
                    //             ->title('Realize a operação com no máximo 20 itens')
                    //             ->warning()
                    //             ->send();
                    //             return false;
                    //         }else{
                    //             Notification::make()
                    //             ->title('Ativado com sucesso')
                    //             ->success()
                    //             ->send();

                    //             $users->each->update(['active' => true]);
                    //         }
                    //     }),
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
}
