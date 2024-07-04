<?php

namespace App\Filament\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CategoryDocuments: string implements HasLabel, HasColor
{
    case ROTINA = 'rotina';
    case INTELIGÊNCIA = 'inteligencia';
    case NADA = '';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::ROTINA => 'ROTINA',
            self::INTELIGÊNCIA => 'INTELIGÊNCIA',
            self::NADA => 'SEM CATEGORIA',
        };
    }
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ROTINA => 'success',
            self::INTELIGÊNCIA => 'danger',
            self::NADA => 'gray',
        };
    }
}
