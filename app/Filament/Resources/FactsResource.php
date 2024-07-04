<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FactsResource\Pages;
use App\Filament\Resources\FactsResource\RelationManagers;
use App\Models\Facts\FactsType;
use App\Models\Facts\Facts;
use App\Models\Registers\Registers;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Cep;

class FactsResource extends Resource
{
    protected static ?string $model = Facts::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Fatos';

    public static function getNavigationLabel(): string
    {
        return 'Fatos';
    }

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                tabs::make('Tabs')
                    ->columns(6)
                    ->tabs([
                        Tabs\Tab::make('Dados gerais')
                            ->icon('heroicon-m-bell')
                            ->schema([
                                Forms\Components\TextInput::make('assunto')
                                    ->columnSpan(6)->required(),
                                Forms\Components\DatePicker::make('data')
                                    ->format('d/m/Y')
                                    ->required()
                                    ->columnSpan(2),
                                Forms\Components\Select::make('facts_types_id')
                                    ->label('Tipo de fato')
                                    ->options(FactsType::all()->pluck('tipo', 'id')->sortBy('tipo')->toArray())
                                    ->required()
                                    ->native(false)
                                    ->allowHtml()
                                    ->preload()
                                    ->live()
                                    ->searchable()
                                    ->columnSpan(3),
                                Forms\Components\TextInput::make('fonte')
                                    ->columnSpan(1)->label('Fonte'),
                            ]),
                        Tabs\Tab::make('Descrição do fato')
                            ->icon('heroicon-m-pencil-square')
                            ->schema([
                                Forms\Components\RichEditor::make('descricao')
                                    ->label('Descrição')
                                    ->columnSpan(6),
                            ]),
                        Tabs\Tab::make('Endereços')
                            ->icon('heroicon-m-map-pin')
                            ->schema([
                                Repeater::make('local')
                                    ->schema([
                                        Cep::make('postal_code')
                                            ->viaCep(
                                                mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                                                errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.

                                                /**
                                                 * Other form fields that can be filled by ViaCep.
                                                 * The key is the name of the Filament input, and the value is the ViaCep attribute that corresponds to it.
                                                 * More information: https://viacep.com.br/
                                                 */
                                                setFields: [
                                                    'address' => 'logradouro',
                                                    'number' => 'numero',
                                                    'complement' => 'complemento',
                                                    'district' => 'bairro',
                                                    'city' => 'localidade',
                                                    'state' => 'uf'
                                                ]
                                            )->live(onBlur: true)->label(__('filament-general-settings::default.postal_code'))->columnSpan(1),
                                        TextInput::make('address')->label(__('filament-general-settings::default.address'))->columnSpan(4),
                                        TextInput::make('number')->label(__('filament-general-settings::default.number'))->columnSpan(1),
                                        TextInput::make('district')->label(__('filament-general-settings::default.district'))->columnSpan(3),
                                        TextInput::make('city')->label(__('filament-general-settings::default.city'))->columnSpan(2),
                                        TextInput::make('state')->label(__('filament-general-settings::default.state'))->columnSpan(1),
                                        TextInput::make('complement')->label(__('filament-general-settings::default.complement'))->columnSpan(6),
                                    ])->columnSpan(6)
                            ]),

                        Tabs\Tab::make('Vínculos')
                            ->icon('heroicon-m-share')
                            ->schema([
                                Forms\Components\Select::make('palavraChave')
                                    ->label('Palavras chave')
                                    ->options(Registers::all()->pluck('envolvidos', 'id')->sortBy('nome')->toArray())
                                    ->multiple()
                                    ->native(false)
                                    ->allowHtml()
                                    ->preload()
                                    ->live()
                                    ->columnSpan(6)
                            ]),

                        Tabs\Tab::make('Anexos')
                            ->icon('heroicon-m-document-plus')
                            ->schema([
                                Forms\Components\FileUpload::make('anexos')
                                    ->directory(
                                        fn ($record, $get) => 'facts/' . $get('id') . '/anexos'
                                    )
                                    ->multiple()
                                    ->openable()
                                    ->downloadable()
                                    ->columnSpan(6)
                            ])->visible(
                                fn ($record, $get) => Facts::query()
                                    ->where([
                                        'id' => $get('id'),
                                    ])->exists()
                            ),

                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('data')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('id')->label('Nº')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('assunto')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type.tipo')->label('Tipo'),

            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->multiple()
                    ->relationship('type', 'tipo'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListFacts::route('/'),
            'create' => Pages\CreateFacts::route('/create'),
            'edit' => Pages\EditFacts::route('/{record}/edit'),
        ];
    }
}
