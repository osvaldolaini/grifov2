<?php

namespace App\Filament\Resources\FactsTypesResource\Pages;

use App\Filament\Resources\FactsTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFactsTypes extends EditRecord
{
    protected static string $resource = FactsTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
