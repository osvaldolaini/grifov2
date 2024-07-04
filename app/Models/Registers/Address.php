<?php

namespace App\Models\Registers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'id', 'postalCode', 'number', 'address', 'district', 'city', 'state', 'complement',
        'registers_id', 'updated_by', 'created_by',
    ];
    protected $casts = [
        'active' => 'boolean',
    ];
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = mb_strtoupper($value);
    }

    public function registers()
    {
        return $this->hasMany(Registers::class);
    }
}
