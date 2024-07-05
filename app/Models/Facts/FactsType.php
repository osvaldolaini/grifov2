<?php

namespace App\Models\Facts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactsType extends Model
{
    use HasFactory;

    protected $table = 'facts_types';

    protected $fillable = [
        'id', 'tipo', 'active', 'updated_by', 'created_by',
    ];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function setTipoAttribute($value)
    {
        $this->attributes['tipo'] = mb_strtoupper($value);
    }
    public function getTipoAttribute($value)
    {
        return mb_strtoupper($value);
    }
    public function facts()
    {
        return $this->hasMany(Facts::class);
    }
}
