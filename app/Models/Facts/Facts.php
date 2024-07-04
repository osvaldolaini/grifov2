<?php

namespace App\Models\Facts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facts extends Model
{
    use HasFactory;

    protected $table = 'facts';

    protected $fillable = [
        'id', 'numero', 'categoria', 'active', 'facts_types_id', 'nome', 'assunto',
        'fonte', 'local', 'descricao', 'palavraChave', 'data',
        'updated_by', 'created_by',
    ];
    public function setDataAttribute($value)
    {
        if ($value != "") {
            $this->attributes['data'] = implode("-", array_reverse(explode("/", $value)));
        } else {
            $this->attributes['data'] = NULL;
        }
    }
    public function getDataAttribute($value)
    {
        if ($value != "") {
            return Carbon::createFromFormat('Y-m-d', $value)
                ->format('d/m/Y');
        }
    }
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = mb_strtoupper($value);
    }
    protected $casts = [
        'data' => 'datetime:Y-m-d',
        'active' => 'boolean',
        'anexos' => 'array',
        'palavraChave' => 'array',
        'local' => 'array'
    ];

    public function type()
    {
        return $this->belongsTo(FactsType::class,  'facts_types_id', 'id');
    }
}
