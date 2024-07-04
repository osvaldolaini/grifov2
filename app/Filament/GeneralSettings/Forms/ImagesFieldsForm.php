<?php

namespace App\Filament\GeneralSettings\Forms;

use Filament\Forms\Components\FileUpload;

class ImagesFieldsForm
{
    public static function get(): array
    {
        return [
            FileUpload::make('logo')
                // ->image()
                // ->imageEditor()
                // ->multiple()
                ->directory('logos')
                // ->storeFileNamesIn('logo')
                ->columnSpanFull()
                ->label(__('filament-general-settings::default.images')),
        ];
    }
}
