<?php

namespace App\Models\Registers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\Documents\Documents;
use App\Models\Facts\Facts;

class Registers extends Model
{
    use HasFactory;

    protected $table = 'registers';

    protected $fillable = [
        'id', 'registers_types_id', 'active',
        'tipo', 'nome', 'codNome', 'sexo', 'especialidade', 'nascimento', 'nacionalidade',
        'pai', 'mae', 'endereco', 'cep', 'celular', 'fixo', 'rg', 'naturalidade',
        'cpf', 'passaporte', 'militar', 'estrangeiro', 'saram', 'postoGrad',
        'imagem', 'obs', 'palavraChave', 'cnpj', 'parentes', 'contatos', 'enderecos',

        'aeronave_prefixo', 'aeronave_proprietario', 'aeronave_outros_proprietarios', 'aeronave_sg_uf',
        'aeronave_cpf_cnpj', 'aeronave_nm_operador', 'aeronave_outros_operadores', 'aeronave_uf_operador',
        'aeronave_cpf_cgc', 'aeronave_nr_cert_matricula', 'aeronave_nr_serie', 'aeronave_cd_categoria',
        'aeronave_cd_tipo', 'aeronave_ds_modelo', 'aeronave_nm_fabricante', 'aeronave_cd_tipo_icao',
        'aeronave_nr_passageiros_max', 'aeronave_cd_marca_estrangeira', 'aeronave_dt_matricula',
        'updated_by', 'created_by',
        'postal_code', 'number', 'address', 'district', 'city', 'state', 'complement'
    ];

    protected $casts = [
        'nascimento' => 'datetime:Y-m-d',
        'active' => 'boolean',
        'imagem' => 'array',
        'parentes' => 'array',
        'contatos' => 'array',
        'enderecos' => 'array',
    ];

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = mb_strtoupper($value);
    }
    public function getNomeAttribute($value)
    {
        return mb_strtoupper($value);
    }
    public function setNascimentoAttribute($value)
    {
        if ($value != "") {
            $this->attributes['nascimento'] = implode("-", array_reverse(explode("/", $value)));
        } else {
            $this->attributes['nascimento'] = NULL;
        }
    }
    public function getNascimentoAttribute($value)
    {
        if ($value != "") {
            return Carbon::createFromFormat('Y-m-d', $value)
                ->format('d/m/Y');
        }
    }
    public function getEnvolvidosAttribute()
    {
        return $this->nome . '(' . $this->id . ')';
    }

    public function type()
    {
        return $this->belongsTo(RegistersType::class, 'registers_types_id', 'id');
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function contacts()
    {
        return $this->hasMany(Contacts::class);
    }
    public function getIdentificacaoAttribute()
    {
        $docs = [];
        if ($this->cpf) {
            $docs['CPF'] = $this->cpf;
        }
        if ($this->cnpj) {
            $docs['CNPJ'] = $this->cnpj;
        }
        if ($this->rg) {
            $docs['RG'] = $this->rg;
        }
        if ($this->saram) {
            $docs['SARAM'] = $this->saram;
        }
        if ($this->postoGrad) {
            $docs['POSTO/GRAD'] = $this->postoGrad;
        }
        return $docs;
    }

    public function getDocumentsAttribute()
    {
        $documents = array();
        $docs = Documents::where('palavraChave', 'LIKE', "%" . $this->id . "%")->get();
        $facts = Facts::where('palavraChave', 'LIKE', "%" . $this->id . "%")->get();

        if ($docs) {
            foreach ($docs as $doc) {
                if ($doc) {
                    $documents['documents/' . $doc->id] = $doc->number;
                }
            }
        }
        if ($facts) {
            foreach ($facts as $fact) {
                if ($fact) {
                    $documents['facts/' . $fact->id] = $fact->number;
                }
            }
        }
        return $documents;
    }
    public function getKeyWordsAttribute()
    {
        $palavraChave = array();
        $docs = Documents::where('palavraChave', 'LIKE', "%" . $this->id . "%")->get();

        if ($docs) {
            foreach ($docs as $doc) {
                if ($doc->palavraChave) {
                    foreach ($doc->palavraChave as $value) {
                        $value = (int) $value;
                        $palavraChave[] = $value;
                    }
                }
            }
        }
        $facts = Facts::where('palavraChave', 'LIKE', "%" . $this->id . "%")->get();

        if ($facts) {
            foreach ($facts as $fact) {
                if ($fact->palavraChave) {
                    foreach ($fact->palavraChave as $value) {
                        $value = (int) $value;
                        $palavraChave[] = $value;
                    }
                }
            }
        }

        $keyWords = $palavraChave;
        // Encontrar o índice do item
        $index = array_search($this->id, $keyWords);
        if ($index !== false) {
            // Remover o item pelo índice
            unset($keyWords[$index]);
            // Reindexar o array para evitar chaves numéricas não sequenciais
            $keyWords = array_values($keyWords);
        }
        // Contar as ocorrências de cada valor
        $countedValues = array_count_values($keyWords);

        // Criar a nova array no formato desejado
        $newArray = [];

        foreach ($countedValues as $id => $qtd) {
            $newArray[] = ['id' => $id, 'nome' => Registers::find($id)->nome, 'qtd' => $qtd];
        }
        return json_encode($newArray);
    }
    // Função para obter os subníveis de vínculos
    private function getSubLinks($id)
    {
        $subLinks = [];

        // Buscar documentos relacionados ao vínculo
        $docs = Documents::where('palavraChave', 'LIKE', "%" . $id . "%")->get();

        foreach ($docs as $doc) {
            if ($doc->palavraChave) {
                foreach ($doc->palavraChave as $value) {
                    $value = (int) $value;
                    if ($value != $id) {
                        $subLinks[] = ['id' => $value, 'nome' => Registers::find($value)->nome];
                    }
                }
            }
        }

        // Buscar fatos relacionados ao vínculo
        $facts = Facts::where('palavraChave', 'LIKE', "%" . $id . "%")->get();

        foreach ($facts as $fact) {
            if ($fact->palavraChave) {
                foreach ($fact->palavraChave as $value) {
                    $value = (int) $value;
                    if ($value != $id) {
                        $subLinks[] = ['id' => $value, 'nome' => Registers::find($value)->nome];
                    }
                }
            }
        }

        return $subLinks;
    }
}
