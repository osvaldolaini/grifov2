<?php

namespace App\Filament\Resources\RegisterTypesResource\Pages;

use App\Filament\Resources\RegisterTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegisterTypes extends ListRecords
{
    protected static string $resource = RegisterTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
