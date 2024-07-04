<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistersResource\Pages;
use App\Filament\Resources\RegistersResource\RelationManagers;
use App\Models\Registers\Registers;
use App\Models\Registers\RegistersType;
use App\Models\Registers\RegistersTypeFields;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;

use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegistersResource extends Resource
{
    protected static ?string $model = Registers::class;
    // protected string $heading = 'Cadastros';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return 'Cadastros';
    }

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
                                Forms\Components\Select::make('registers_types_id')
                                    ->label('Tipo de cadastro')
                                    ->options(RegistersType::all()->pluck('nome', 'id')->sortBy('nome')->toArray())
                                    ->required()
                                    ->native(false)
                                    ->allowHtml()
                                    ->preload()
                                    ->live()
                                    ->searchable()
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('nome')
                                    ->columnSpan(3)->required(),
                                Forms\Components\Select::make('militar')
                                    ->label('Militar?')
                                    ->required()
                                    ->default(0)
                                    ->placeholder(false)
                                    ->columnSpan(1)
                                    ->options([
                                        0 => 'Não',
                                        1 => 'Sim'
                                    ])
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'estrangeiro'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('codNome')
                                    ->label('Nome de Guerra / Apelido')
                                    ->columnSpan(2)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'codNome'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('cpf')
                                    ->label('CPF')
                                    ->mask('999.999.999-99')
                                    ->rule('cpf')
                                    ->columnSpan(2)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'cpf'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('rg')
                                    ->label('RG')
                                    ->columnSpan(1)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'rg'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('saram')
                                    ->label('SARAM')
                                    ->mask('999999-9')
                                    ->columnSpan(1)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'saram'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('cnpj')
                                    ->label('CNPJ')
                                    ->mask('99.999.999/9999-99')
                                    ->rule('cnpj')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'cnpj'
                                            ])->exists()
                                    ),
                                Forms\Components\Select::make('sexo')
                                    ->label('Sexo')
                                    ->placeholder('Selecione...')
                                    ->columnSpan(1)
                                    ->options([
                                        'm' => 'M',
                                        'f' => 'F'
                                    ])
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'sexo'
                                            ])->exists()
                                    ),
                                Forms\Components\DatePicker::make('nascimento')
                                    ->format('d/m/Y')
                                    ->columnSpan(2)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'nascimento'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('nacionalidade')
                                    ->columnSpan(1)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'nacionalidade'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('naturalidade')
                                    ->columnSpan(2)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'naturalidade'
                                            ])->exists()
                                    ),
                                Forms\Components\Select::make('estrangeiro')
                                    ->placeholder(false)
                                    ->columnSpan(1)
                                    ->default(0)
                                    ->options([
                                        0 => 'Não',
                                        1 => 'Sim'
                                    ])
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'estrangeiro'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('passaporte')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'passaporte'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_prefixo')
                                    ->label('Prefixo')
                                    ->columnSpan(2)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_prefixo'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_proprietario')
                                    ->label('Proprietário')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_proprietario'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_outros_proprietarios')
                                    ->label('Outros proprietário')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_outros_proprietarios'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_sg_uf')
                                    ->label('Estado (UF)')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_sg_uf'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_nm_operador')
                                    ->label('Operador')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_nm_operador'
                                            ])->exists()
                                    ),
                            ]),
                        Tabs\Tab::make('Parentes')
                            ->icon('heroicon-m-users')
                            ->schema([
                                Repeater::make('parentesco')
                                    ->schema([
                                        Forms\Components\TextInput::make('parentesco')->helperText('Ex: Pai, Mãe, Namorada')
                                            ->required()->columnSpan(2),
                                        Forms\Components\TextInput::make('name')->required()->columnSpan(4),
                                    ])->columnSpan(6)->columns(6)
                            ])->visible(
                                fn ($record, $get) => RegistersTypeFields::query()
                                    ->where([
                                        'registers_type_id' => $get('registers_types_id'),
                                        'field_name' => 'parentesco'
                                    ])->exists()
                            ),
                        Tabs\Tab::make('Endereços')
                            ->icon('heroicon-m-map-pin')
                            ->schema([
                                Repeater::make('enderecos')
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
                            ])->visible(
                                fn ($record, $get) => RegistersTypeFields::query()
                                    ->where([
                                        'registers_type_id' => $get('registers_types_id'),
                                        'field_name' => 'enderecos'
                                    ])->exists()
                            ),
                        Tabs\Tab::make('Contatos')
                            ->icon('heroicon-m-share')
                            ->schema([
                                Repeater::make('contatos')
                                    ->schema([
                                        Forms\Components\TextInput::make('tipo')
                                            ->helperText('Ex: telefone, rede social, email')
                                            ->required()->columnSpan(2),
                                        Forms\Components\TextInput::make('contato')->required()->columnSpan(4),
                                    ])->columnSpan(6)->columns(6)
                            ])->visible(
                                fn ($record, $get) => RegistersTypeFields::query()
                                    ->where([
                                        'registers_type_id' => $get('registers_types_id'),
                                        'field_name' => 'contatos'
                                    ])->exists()
                            ),

                        Tabs\Tab::make('Observação')
                            ->icon('heroicon-m-pencil-square')
                            ->schema([
                                Forms\Components\RichEditor::make('obs')
                                    ->columnSpan(6)->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'obs'
                                            ])->exists()
                                    ),
                            ])->visible(
                                fn ($record, $get) => RegistersTypeFields::query()
                                    ->where([
                                        'registers_type_id' => $get('registers_types_id'),
                                        'field_name' => 'obs'
                                    ])->exists()
                            ),

                        Tabs\Tab::make('Imagens')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('imagem')
                                    ->multiple()
                                    ->directory('cadastros')
                                    ->columnSpan(6)->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'imagem'
                                            ])->exists()
                                    ),
                            ])->visible(
                                fn ($record, $get) => RegistersTypeFields::query()
                                    ->where([
                                        'registers_type_id' => $get('registers_types_id'),
                                        'field_name' => 'imagem'
                                    ])->exists()
                            ),
                        Tabs\Tab::make('Dados técnicos')
                            ->icon('heroicon-m-ellipsis-horizontal-circle')
                            ->schema([
                                Forms\Components\TextInput::make('aeronave_outros_operadores')
                                    ->label('Outros operador')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_outros_operadores'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_uf_operador')
                                    ->label('UF do operador')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_uf_operador'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_cpf_cgc')
                                    ->label('CPF / CGC')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_cpf_cgc'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_nr_cert_matricula')
                                    ->label('Certificado')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_nr_cert_matricula'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_nr_serie')
                                    ->label('Nº de série')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_nr_serie'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_cd_categoria')
                                    ->label('Categoria')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_cd_categoria'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_nm_fabricante')
                                    ->label('Fabricante')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_nm_fabricante'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_cd_tipo')
                                    ->label('Tipo')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_cd_tipo'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_nr_passageiros_max')
                                    ->label('Nº Passageiros')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_nr_passageiros_max'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_cd_tipo_icao')
                                    ->label('Tipo ICAO')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_cd_tipo_icao'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_cd_marca_estrangeira')
                                    ->label('Marca estrangeira')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_cd_marca_estrangeira'
                                            ])->exists()
                                    ),
                                Forms\Components\TextInput::make('aeronave_dt_matricula')
                                    ->label('DT Matricula')
                                    ->columnSpan(3)
                                    ->visible(
                                        fn ($record, $get) => RegistersTypeFields::query()
                                            ->where([
                                                'registers_type_id' => $get('registers_types_id'),
                                                'field_name' => 'aeronave_dt_matricula'
                                            ])->exists()
                                    ),

                            ])->visible(
                                fn ($record, $get) => RegistersTypeFields::query()
                                    ->where([
                                        'registers_type_id' => $get('registers_types_id'),
                                        'field_name' => 'aeronave_prefixo'
                                    ])->exists()
                            ),
                    ])->columnSpanFull()
            ]);



        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('cpf')->label('CPF')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('cnpj')->label('CNPJ')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('saram')->label('SARAM')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type.nome')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                // ->badge('type.cor')
                // ->color('type.cor'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->multiple()
                    ->relationship('type', 'nome')
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
            'index' => Pages\ListRegisters::route('/'),
            'create' => Pages\CreateRegisters::route('/create'),
            'edit' => Pages\EditRegisters::route('/{record}/edit'),
        ];
    }
}
