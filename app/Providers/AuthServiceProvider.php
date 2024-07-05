<?php

namespace App\Providers;

use App\Models\Documents\Documents;
use App\Models\Documents\DocumentsType;
use App\Models\Facts\Facts;
use App\Models\Facts\FactsType;
use App\Policies\ActivityPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use App\Models\GeneralSetting;
use App\Models\Registers\Registers;
use App\Models\Registers\RegistersType;
use App\Models\Registers\RegistersTypeFields;
use App\Policies\Documents\DocumentsPolicy;
use App\Policies\Documents\DocumentsTypePolicy;
use App\Policies\Facts\FactsPolicy;
use App\Policies\Facts\FactsTypePolicy;
use App\Policies\GeneralSettingPolicy;
use App\Policies\Registers\RegistersPolicy;
use App\Policies\Registers\RegistersTypeFieldsPolicy;
use App\Policies\Registers\RegistersTypePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Update `Activity::class` with the one defined in `config/activitylog.php`
        Activity::class => ActivityPolicy::class,
        GeneralSetting::class => GeneralSettingPolicy::class,
        Documents::class => DocumentsPolicy::class,
        DocumentsType::class => DocumentsTypePolicy::class,
        Registers::class => RegistersPolicy::class,
        RegistersType::class => RegistersTypePolicy::class,
        RegistersTypeFields::class => RegistersTypeFieldsPolicy::class,
        Facts::class => FactsPolicy::class,
        FactsType::class => FactsTypePolicy::class,

    ];
    //...
}
