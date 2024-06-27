<?php

namespace App\Filament\GeneralSettings\Forms;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use App\Filament\GeneralSettings\Enums\TypeFieldEnum;

class CustomForms
{
    public static function get(array $customFields): array
    {
        $fields = [];
        foreach ($customFields as $fieldKey => $field) {

            if ($field['type'] === TypeFieldEnum::Text->value) {

                $fields[] = TextInput::make($fieldKey)
                    ->label(__($field['label']))
                    ->placeholder(__($field['placeholder']))
                    ->required($field['required'])
                    ->rules($field['rules']);
            } elseif ($field['type'] === TypeFieldEnum::Boolean->value) {

                $fields[] = Checkbox::make($fieldKey)
                    ->label(__($field['label']));
            } elseif ($field['type'] === TypeFieldEnum::Select->value) {

                $fields[] = Select::make($fieldKey)
                    ->label(__($field['label']))
                    ->placeholder(__($field['placeholder']))
                    ->options($field['options'])
                    ->required($field['required']);
            } elseif ($field['type'] === TypeFieldEnum::Textarea->value) {

                $fields[] = Textarea::make($fieldKey)
                    ->label(__($field['label']))
                    ->placeholder(__($field['placeholder']))
                    ->rows($field['rows'])
                    ->required($field['required']);
            } elseif ($field['type'] === TypeFieldEnum::Datetime->value) {

                $fields[] = DateTimePicker::make($fieldKey)
                    ->label(__($field['label']))
                    ->placeholder(__($field['placeholder']))
                    ->seconds($field['seconds']);
            }
        }

        return $fields;
    }
}
