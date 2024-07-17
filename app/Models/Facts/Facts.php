<?php

namespace App\Models\Facts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;

use App\Models\Registers\Registers;

class Facts extends Model implements FilamentUser
{
    use HasFactory;
    use HasRoles;
    use HasPanelShield;

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
    public function getAssuntoAttribute($value)
    {
        return mb_strtoupper($value);
    }
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = mb_strtoupper($value);
        $this->attributes['active'] = 1;
    }
    protected $casts = [
        'data' => 'datetime:Y-m-d',
        'active' => 'boolean',
        'anexos' => 'array',
        'palavraChave' => 'array',
        'local' => 'array'
    ];
    public function getVinculosAttribute()
    {
        // dd($this->palavraChave);
        if (is_array($this->palavraChave)) {
            $participantes = array();
            foreach ($this->palavraChave as $envolvido) {
                $register = Registers::find($envolvido);
                if ($register) {
                    $participantes[$register->id] = $register->nome . ($register->cpf ? ' - ' . $register->cpf : ($register->cnpj ? ' - ' . $register->cnpj : ''));
                }
            }
            return $participantes;
        }
        // dd($participantes);
    }

    public function getNumberAttribute()
    {
        return $this->assunto . ' - Fato Nº ' . $this->id . ' de ' . $this->data;
    }

    public function type()
    {
        return $this->belongsTo(FactsType::class,  'facts_types_id', 'id');
    }
}
