<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegisterTypesResource\Pages;
use App\Filament\Resources\RegisterTypesResource\RelationManagers;
use App\Models\Registers\RegistersType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\ColorPicker;

class RegisterTypesResource extends Resource implements HasShieldPermissions
{

    protected static ?string $model = RegistersType::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return 'Tipos de cadastros';
    }
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'fields'
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()->columnSpan(3),
                ColorPicker::make('cor')
                    ->label('Cor')
                    ->prefixIcon('heroicon-o-swatch')
                    ->helperText(__('Cor da categoria'))
                    ->columnSpan(2),
                Forms\Components\Toggle::make('active')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->label('Ativo')
                    ->onColor('success')
                    ->offColor('danger')->inline(false)->columnSpan(1),
            ])->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')->label('Nome')->searchable()->sortable(),
                Tables\Columns\ToggleColumn::make('active')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->label('Ativo')
                    ->onColor('success')
                    ->offColor('danger'),

                Tables\Columns\IconColumn::make('id')
                    ->label('Campos')
                    ->icon('heroicon-o-queue-list')
                    ->color('success')
                    ->alignCenter()
                    ->url(fn ($record) => url("/admin/register-types/{$record->id}/fields"))
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
                // Tables\Actions\Action::make('viewFields')
                //     ->label('Campos')
                //     ->url(fn ($record) => url("/admin/register-types/{$record->id}/fields"))
                //     ->icon('heroicon-m-queue-list')
                //     ->color('success'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()

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
            'index' => Pages\ListRegisterTypes::route('/'),
            'create' => Pages\CreateRegisterTypes::route('/create'),
            'edit' => Pages\EditRegisterTypes::route('/{record}/edit'),
            'fields' => Pages\FieldsRegisterTypes::route('/{record}/fields'),
        ];
    }
}
