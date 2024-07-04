<?php

namespace App\Filament\Resources\FactsTypesResource\Pages;

use App\Filament\Resources\FactsTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFactsTypes extends ListRecords
{
    protected static string $resource = FactsTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
