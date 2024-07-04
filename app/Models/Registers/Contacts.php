<?php

namespace App\Models\Registers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'id', 'type', 'contact', 'registers_id', 'updated_by', 'created_by',
    ];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function registers()
    {
        return $this->hasMany(Registers::class);
    }
}
