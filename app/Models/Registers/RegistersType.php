<?php

namespace App\Models\Registers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Traits\HasRoles;

class RegistersType extends Model implements FilamentUser
{
    use HasFactory;

    use HasRoles;
    use HasPanelShield;
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }

    protected $table = 'registers_types';

    protected $fillable = [
        'id', 'nome', 'cor', 'updated_by', 'created_by',
    ];
    protected $casts = [
        'active' => 'boolean',
    ];
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = mb_strtoupper($value);
    }

    public function registers()
    {
        return $this->hasMany(Registers::class);
    }

    public function fields()
    {
        return $this->hasMany(RegistersTypeFields::class);
    }
}
