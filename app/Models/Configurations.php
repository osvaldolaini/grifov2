<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Configurations extends Model
{
    use HasFactory;
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }

    protected $table = 'configurations';

    protected $fillable = [
        'title', 'acronym', 'slug', 'update_by', 'logo_path', 'image',
        'email', 'phone', 'cellphone', 'whatsapp', 'telegram', 'cnpj',
        'postalCode', 'number', 'address', 'district', 'city', 'state', 'complement',
        'about', 'meta_description', 'meta_tags', 'video_link'

    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = mb_strtoupper($value);
        $this->attributes['slug'] = Str::slug($value);
    }
}
