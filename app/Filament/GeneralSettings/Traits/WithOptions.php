<?php

namespace App\Filament\GeneralSettings\Traits;

trait WithOptions
{
    public static function options(): array
    {
        return collect(static::cases())->mapWithKeys(function ($item) {
            return [$item->value => __($item->name)];
        })->toArray();
    }
}
