<?php

namespace App\Models\Documents;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;

class Documents extends Model implements FilamentUser
{
    use HasFactory;
    use HasRoles;
    use HasPanelShield;

    protected $table = 'docs';

    protected $fillable = [
        'id', 'tipoNome', 'categoria', 'active', 'docs_types_id', 'status', 'origem',
        'destino', 'numero', 'numeroExpedicao', 'palavraChave', 'data', 'referencia',
        'assunto', 'resenha', 'descricao', 'anexos', 'documento',
        'updated_by', 'created_by',
    ];
    public function setTipoNomeAttribute($value)
    {
        $this->attributes['tipoNome'] = mb_strtoupper($value);
    }
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
    public function getReferenceAttribute()
    {
        return $this->type->nome . ' Nº ' . $this->numeroExpedicao . '/' . $this->origem . ' de ' . $this->data;
    }


    protected $casts = [
        'data' => 'datetime:Y-m-d',
        'active' => 'boolean',
        'anexos' => 'array',
        'palavraChave' => 'array',
        'destino' => 'array',
        'referencia' => 'array',
    ];

    public function type()
    {
        return $this->belongsTo(DocumentsType::class,  'docs_types_id', 'id');
    }
}
