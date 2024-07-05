<?php

namespace App\Filament\Resources\RegisterTypesResource\Pages;

use App\Filament\Resources\RegisterTypesResource;
use App\Models\Registers\RegistersTypeFields;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Support\Facades\DB;


class FieldsRegisterTypes extends Page
{
    // use HasPageShield;
    use InteractsWithRecord;

    protected static string $resource = RegisterTypesResource::class;
    public $fields = [];
    public $selectedColumns = [];

    protected ?string $heading = 'Campos da categoria ';

    protected static string $view = 'filament.resources.register-types-resource.pages.fields-register-types';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->fields = DB::getSchemaBuilder()->getColumnListing('registers');
        // Removendo as colunas
        $this->fields = array_diff($this->fields, [
            "postal_code", "number", "address", "district", "city", "tipo", "nome", "endereco",
            "complement", "created_at", "registers_types_id", "palavraChave", "pai", "mae",
            "updated_at", "updated_by", "created_by", "id", "active", "cep", "fixo", "contato", "celular"
        ]);
        $this->fields = array_merge($this->fields);
        // Inicializando selectedColumns com base na tabela pivot
        $this->selectedColumns = RegistersTypeFields::where('registers_type_id', $this->record->id)
            ->pluck('field_name')
            ->toArray();
        $this->heading .= '( ' . $this->record->nome . ' )';
        // dd($this->selectedColumns);
    }

    public function toggleField($field)
    {
        if (in_array($field, $this->selectedColumns)) {
            // Remover da tabela pivot
            RegistersTypeFields::where('registers_type_id', $this->record->id)
                ->where('field_name', $field)
                ->delete();
        } else {
            // Adicionar na tabela pivot
            RegistersTypeFields::create([
                'registers_type_id' => $this->record->id,
                'field_name' => $field,
            ]);
        }

        // Atualizar selectedColumns
        $this->selectedColumns = RegistersTypeFields::where('registers_type_id', $this->record->id)
            ->pluck('field_name')
            ->toArray();
        $this->heading .= '( ' . $this->record->nome . ' )';
    }
}
