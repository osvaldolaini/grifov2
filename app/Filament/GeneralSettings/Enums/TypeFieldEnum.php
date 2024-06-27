<?php

namespace App\Filament\GeneralSettings\Enums;

use App\Filament\GeneralSettings\Traits\WithOptions;

enum TypeFieldEnum: string
{
    use WithOptions;

    case Text = 'text';
    case Boolean = 'boolean';
    case Select = 'select';
    case Textarea = 'textarea';
    case Datetime = 'datetime';
}
