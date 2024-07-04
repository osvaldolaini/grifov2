<?php

namespace App\Filament\Resources\FactsResource\Pages;

use App\Filament\Resources\FactsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFacts extends ListRecords
{
    protected static string $resource = FactsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
