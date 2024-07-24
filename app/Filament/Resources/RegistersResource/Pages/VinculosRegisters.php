<?php

namespace App\Filament\Resources\RegistersResource\Pages;

use App\Filament\Resources\RegistersResource;
use App\Models\Documents\Documents;
use App\Models\Facts\Facts;
use App\Models\Registers\Registers;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Unique;

class VinculosRegisters extends Page
{
    // use HasPageShield;
    use InteractsWithRecord;

    protected static string $resource = RegistersResource::class;
    // public $documents = [];
    public $keyWords = [];
    public $mainNodeId;

    protected ?string $heading = 'Vínculos';

    protected static string $view = 'filament.resources.registers-resource.pages.vinculos';

    public $nodes = [];
    public $links = [];
    public $data = [];


    // public function mount(int | string $record): void
    // {
    //     $this->record = $this->resolveRecord($record);
    //     $this->nodes[] = ['id' => $this->record->id, 'name' => $this->record->nome, 'qtd' => 1];
    //     foreach (json_decode($this->record->keyWords) as $keyWord) {
    //         $this->nodes[] = ['id' => $keyWord->id, 'name' => $keyWord->nome, 'qtd' => $keyWord->qtd];
    //         $this->links[] = ['source' => $this->record->id, 'target' => $keyWord->id, 'qtd' => $keyWord->qtd];
    //     }
    //     // dd($this->data);
    // }
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->mainNodeId = $this->record->id; // ou o ID desejado

        // Conjunto para rastrear nós únicos e vínculos únicos
        $uniqueNodes = [];
        $uniqueLinks = [];
        $nodesMap = []; // Para rastrear nós únicos

        // Adiciona o nó principal apenas uma vez
        $mainNodeId = (int) $this->record->id;
        if (!isset($nodesMap[$mainNodeId])) {
            $nodesMap[$mainNodeId] = true;
            $this->nodes[] = ['id' => $mainNodeId, 'name' => $this->record->nome, 'qtd' => 1];
        }

        // Adiciona os nós e vínculos principais
        foreach (json_decode($this->record->keyWords) as $keyWord) {
            $nodeId = (int) $keyWord->id;
            // Adiciona o nó se não estiver presente no mapa de nós
            if (!isset($nodesMap[$nodeId])) {
                $nodesMap[$nodeId] = true;
                $this->nodes[] = ['id' => $nodeId, 'name' => $keyWord->nome, 'qtd' => $keyWord->qtd];
            }
            $this->addLink($mainNodeId, $nodeId, $keyWord->qtd, $uniqueLinks);

            // Adiciona os subitens (vínculos dos vínculos)
            $subKeyWords = $this->getSubLinks($nodeId); // Função para buscar subitens
            foreach ($subKeyWords as $subKeyWord) {
                $subNodeId = (int) $subKeyWord['id'];
                // Adiciona o subitem ao array de nós se ainda não estiver presente
                if (!isset($nodesMap[$subNodeId])) {
                    $nodesMap[$subNodeId] = true;
                    $this->nodes[] = ['id' => $subNodeId, 'name' => $subKeyWord['nome'], 'qtd' => 1];
                }

                // Adiciona o vínculo entre o vínculo principal e o subitem
                $this->addLink($nodeId, $subNodeId, 1, $uniqueLinks);
            }
        }
    }

    // Função para adicionar um vínculo único
    private function addLink($source, $target, $qtd, &$uniqueLinks)
    {
        $source = (int) $source;
        $target = (int) $target;
        if ($source === $target) {
            return; // Ignorar vínculos de um nó consigo mesmo
        }
        $linkIdentifier = $source < $target ? "$source-$target" : "$target-$source";
        if (!in_array($linkIdentifier, $uniqueLinks)) {
            $this->links[] = ['source' => $source, 'target' => $target, 'qtd' => $qtd];
            $uniqueLinks[] = $linkIdentifier;
        }
    }

    // Função para obter subitens (vínculos dos vínculos)
    private function getSubLinks($id)
    {
        $subLinks = [];

        // Buscar documentos relacionados ao vínculo
        $docs = Documents::where('palavraChave', 'LIKE', "%" . $id . "%")->get();

        foreach ($docs as $doc) {
            if ($doc->palavraChave) {
                foreach ($doc->palavraChave as $value) {
                    $value = (int) $value;
                    if ($value != $id && !in_array($value, array_column($subLinks, 'id'))) {
                        $subLinks[] = ['id' => $value, 'nome' => Registers::find($value)->nome];
                    }
                }
            }
        }

        // Buscar fatos relacionados ao vínculo
        $facts = Facts::where('palavraChave', 'LIKE', "%" . $id . "%")->get();

        foreach ($facts as $fact) {
            if ($fact->palavraChave) {
                foreach ($fact->palavraChave as $value) {
                    $value = (int) $value;
                    if ($value != $id && !in_array($value, array_column($subLinks, 'id'))) {
                        $subLinks[] = ['id' => $value, 'nome' => Registers::find($value)->nome];
                    }
                }
            }
        }

        return $subLinks;
    }
}
