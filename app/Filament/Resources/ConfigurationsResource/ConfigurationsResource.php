<?php

namespace App\Filament\Resources\ConfigurationsResource;

use App\Filament\Resources\ConfigurationsResource\Pages;
use App\Filament\Resources\ConfigurationsResource\RelationManagers;
use App\Models\Configurations;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConfigurationsResource extends Resource
{
    protected static ?string $model = Configurations::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = -1;

    public static function getNavigationLabel(): string
    {
        return __('Configurations');
    }

    public static function getNavigationGroup(): string
    {
        return __('Settings');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListConfigurations::route('/'),
            'create' => Pages\CreateConfigurations::route('/create'),
            'edit' => Pages\EditConfigurations::route('/{record}/edit'),
        ];
    }
}
