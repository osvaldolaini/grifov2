<?php

namespace App\Filament\Resources;

use App\Filament\Enums\CategoryDocumentEnum;
use App\Filament\Enums\CategoryDocuments;
use App\Filament\Resources\DocumentsTypeResource\Pages;
use App\Filament\Resources\DocumentsTypeResource\RelationManagers;
use App\Models\Documents\Documents;
use App\Models\Documents\DocumentsType;
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



class DocumentsTypeResource extends Resource
{
    protected static ?string $model = DocumentsType::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Documentos';

    protected static ?int $navigationSort = 2;

    public static function getLabel(): ?string
    {
        return 'Tipos de documentos';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required(),
                Forms\Components\Select::make('categoria')
                    ->options(CategoryDocuments::class)
                    ->required()
                    ->native(false)
                    ->allowHtml()
                    ->preload()
                    ->live()
                    ->searchable(),
                Forms\Components\Toggle::make('active')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->label('Ativo')
                    ->onColor('success')
                    ->offColor('danger')->inline(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('categoria')
                    ->badge()
                    ->label('Categoria'),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Status')
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
                    ]),
                SelectFilter::make('categoria')
                    ->multiple()
                    ->options(CategoryDocuments::class)
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
            'index' => Pages\ListDocumentsTypes::route('/'),
            'create' => Pages\CreateDocumentsType::route('/create'),
            'edit' => Pages\EditDocumentsType::route('/{record}/edit'),
        ];
    }
}
