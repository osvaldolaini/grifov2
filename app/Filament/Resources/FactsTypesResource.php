<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FactsTypesResource\Pages;
use App\Filament\Resources\FactsTypesResource\RelationManagers;
use App\Models\Facts\FactsType;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FactsTypesResource extends Resource
{
    protected static ?string $model = FactsType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Fatos';

    public static function getNavigationLabel(): string
    {
        return 'Tipos de fatos';
    }

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tipo')
                    ->required()->columnSpan(3),
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
            'index' => Pages\ListFactsTypes::route('/'),
            'create' => Pages\CreateFactsTypes::route('/create'),
            'edit' => Pages\EditFactsTypes::route('/{record}/edit'),
        ];
    }
}
