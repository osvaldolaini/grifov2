<?php

namespace App\Models\Registers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedias extends Model
{
    use HasFactory;

    protected $table = 'social_medias';

    protected $fillable = [
        'id', 'media', 'registers_id', 'updated_by', 'created_by',
    ];
    public function setMediaAttribute($value)
    {
        $this->attributes['media'] = mb_strtoupper($value);
    }
    protected $casts = [
        'active' => 'boolean',
    ];

    public function registers()
    {
        return $this->hasMany(Registers::class);
    }
}
