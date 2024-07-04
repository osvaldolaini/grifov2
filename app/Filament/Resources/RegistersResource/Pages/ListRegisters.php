<?php

namespace App\Filament\Resources\RegistersResource\Pages;

use App\Filament\Resources\RegistersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegisters extends ListRecords
{
    protected static string $resource = RegistersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
