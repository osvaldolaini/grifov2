<?php

namespace App\Filament\Resources\ConfigurationsResource\Pages;

use App\Filament\Resources\ConfigurationsResource\ConfigurationsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConfigurations extends ListRecords
{
    protected static string $resource = ConfigurationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
