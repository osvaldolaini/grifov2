<?php

namespace App\Filament\Resources\RegisterTypesResource\Pages;

use App\Filament\Resources\RegisterTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegisterTypes extends EditRecord
{
    protected static string $resource = RegisterTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
