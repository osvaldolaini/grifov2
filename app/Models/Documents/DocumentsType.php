<?php

namespace App\Models\Documents;

use App\Filament\Enums\CategoryDocuments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsType extends Model
{
    use HasFactory;

    protected $table = 'docs_types';

    protected $fillable = [
        'id', 'nome', 'categoria', 'updated_by', 'created_by',
    ];
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = mb_strtoupper($value);
    }
    protected $casts = [
        'active' => 'boolean',
        'categoria' => CategoryDocuments::class
    ];


    public function docs()
    {
        return $this->hasMany(Documents::class);
    }
}
