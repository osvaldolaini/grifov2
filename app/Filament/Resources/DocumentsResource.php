<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentsResource\Pages;
use App\Filament\Resources\DocumentsResource\RelationManagers;
use App\Models\Documents\Documents;
use App\Models\Documents\DocumentsType;
use App\Models\Registers\Registers;
use App\Tables\Columns\DocumentInfosColumn;
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

class DocumentsResource extends Resource
{
    protected static ?string $model = Documents::class;

    protected static ?string $navigationGroup = 'Documentos';

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function getLabel(): ?string
    {
        return __('Document');
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
                                Forms\Components\Select::make('docs_types_id')
                                    ->label('Tipo de documento')
                                    ->options(DocumentsType::all()->pluck('nome', 'id')->sortBy('nome')->toArray())
                                    ->required()
                                    ->native(false)
                                    ->allowHtml()
                                    ->preload()
                                    ->live()
                                    ->searchable()
                                    ->columnSpan(3),
                                Forms\Components\Select::make('status')
                                    ->label('status')
                                    ->placeholder('Selecione...')
                                    ->columnSpan(1)
                                    ->options([
                                        'expedido' => 'EXPEDIDO',
                                        'recebido' => 'RECEBIDO',
                                        'interno' => 'INTERNO'
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('origem')
                                    ->columnSpan(4),
                                Forms\Components\TextInput::make('numeroExpedicao')
                                    ->columnSpan(2)->label('Número'),
                                Forms\Components\Select::make('destino')
                                    ->label('Destino')
                                    ->options(Registers::all()->pluck('nome', 'nome')->sortBy('nome')->toArray())
                                    ->multiple()
                                    ->native(false)
                                    ->allowHtml()
                                    ->preload()
                                    ->live()
                                    ->columnSpan(3),
                                Forms\Components\Select::make('referencia')
                                    ->label('Referências')
                                    ->options(Documents::all()->pluck('reference', 'id')->sortBy('nome')->toArray())
                                    ->multiple()
                                    ->native(false)
                                    ->allowHtml()
                                    ->preload()
                                    ->live()
                                    ->columnSpan(3)
                            ]),
                        Tabs\Tab::make('Observação')
                            ->icon('heroicon-m-pencil-square')
                            ->schema([
                                Forms\Components\RichEditor::make('descricao')
                                    ->label('Descrição')
                                    ->columnSpan(6),
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
                        Tabs\Tab::make('Documento')
                            ->icon('heroicon-m-document-plus')
                            ->schema([
                                Forms\Components\FileUpload::make('documento')
                                    ->directory(
                                        fn ($record, $get) => 'docs/' . $get('id')
                                    )
                                    ->helperText('Somente documentos em formato PDF')
                                    ->openable()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->downloadable()
                                    ->columnSpan(6)
                            ])->visible(
                                fn ($record, $get) => Documents::query()
                                    ->where([
                                        'id' => $get('id'),
                                    ])->exists()
                            ),
                        Tabs\Tab::make('Anexos')
                            ->icon('heroicon-m-document-plus')
                            ->schema([
                                Forms\Components\FileUpload::make('anexos')
                                    ->directory(
                                        fn ($record, $get) => 'docs/' . $get('id') . '/anexos'
                                    )
                                    ->multiple()
                                    ->openable()
                                    ->downloadable()
                                    ->columnSpan(6)
                            ])->visible(
                                fn ($record, $get) => Documents::query()
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
                Tables\Columns\TextColumn::make('data')->searchable([
                    'data', 'numero', 'id', 'assunto'
                ])->sortable(),
                DocumentInfosColumn::make('number')->label('Dados'),
                // Tables\Columns\TextColumn::make('number')
                //     ->label('Nº'),
                // Tables\Columns\TextColumn::make('status')
                //     ->badge()
                //     ->colors([
                //         'secondary' => 'interno',
                //         'warning' => 'recebido',
                //         'success' => 'expedido',
                //     ])
                //     ->searchable()->sortable(),
                // Tables\Columns\TextColumn::make('assunto')->searchable()->sortable(),
                // Tables\Columns\TextColumn::make('type.nome')
                //     ->label('Tipo'),
                Tables\Columns\TextColumn::make('type.categoria')
                    ->badge()
                    ->label('Categoria'),
            ])
            ->defaultSort('data', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options([
                        'expedido' => 'EXPEDIDO',
                        'recebido' => 'RECEBIDO',
                        'interno' => 'INTERNO'
                    ]),
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->multiple()
                    ->relationship('type', 'nome'),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocuments::route('/create'),
            'edit' => Pages\EditDocuments::route('/{record}/edit'),
        ];
    }
}
