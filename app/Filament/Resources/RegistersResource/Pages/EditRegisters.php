<?php

namespace App\Filament\Resources\RegistersResource\Pages;

use App\Filament\Resources\RegistersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegisters extends EditRecord
{
    protected static string $resource = RegistersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
