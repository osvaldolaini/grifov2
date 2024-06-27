<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Traits\HasRoles;

class GeneralSetting extends Model implements FilamentUser
{
    use HasFactory;
    use LogsActivity;
    use HasRoles;
    use HasPanelShield;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }

    protected $fillable = [
        'site_name',
        'cpf_or_cnpj',
        'site_description',
        'theme_color',
        'support_email',
        'support_phone',
        'google_analytics_id',
        'posthog_html_snippet',
        'seo_title',
        'seo_keywords',
        'seo_metadata',
        'social_network',
        'email_settings',
        'email_from_name',
        'email_from_address',
        'more_configs',
        'postal_code',
        'number',
        'address',
        'district',
        'city',
        'state',
        'complement',
        'logo',
        'favicon'
    ];

    protected $casts = [
        'seo_metadata' => 'array',
        'email_settings' => 'array',
        'social_network' => 'array',
        'more_configs' => 'array',
        // 'logo_path' => 'array',
    ];
}
