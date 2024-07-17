<?php

namespace App\Filament\Widgets;

use App\Models\Documents\Documents;
use App\Models\Facts\Facts;
use App\Models\Registers\Registers;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Schema;

class GlobalSearchWidget extends Widget
{
    protected static string $view = 'filament.widgets.global-search-widget';
    protected int | string | array $columnSpan = 'full';

    public $results = array();
    public $search;
    public $registers = array();
    public $facts = array();
    public $documents  = array();

    public function mount()
    {
        $this->results = [
            'registers' => $this->registers,
            'facts'     => $this->facts,
            'documents' => $this->documents,
        ];
    }

    public function updated($property)
    {
        if ($property === 'search') {
            if (strlen($this->search) > 4) {
                //Cadastros
                $columns = Schema::getColumnListing((new registers)->getTable());
                $query = registers::query();
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $this->search . '%');
                }
                $this->registers = $query->limit(25)->get();

                //Fatos
                $columnsFacts = Schema::getColumnListing((new Facts())->getTable());
                $queryF = Facts::query();
                foreach ($columnsFacts as $facts) {
                    $queryF->orWhere($facts, 'like', '%' . $this->search . '%');
                }
                $this->facts = $queryF->limit(25)->get();

                //Documentos
                $columnsDocuments = Schema::getColumnListing((new Documents())->getTable());
                $queryD = Documents::query();
                foreach ($columnsDocuments as $docs) {
                    $queryD->orWhere($docs, 'like', '%' . $this->search . '%');
                }
                $this->documents = $queryD->limit(25)->get();

                //Resultado
                $this->results = [
                    'registers' => $this->registers,
                    'facts' => $this->facts,
                    'documents' => $this->documents,
                ];
            }
        }
    }
}
