<?php

namespace App\Providers;

use App\Models\Documents\DocumentsType;
use App\Policies\ActivityPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use App\Models\GeneralSetting;
use App\Models\Registers\RegistersType;
use App\Models\Registers\RegistersTypeFields;
use App\Policies\Documents\DocumentsTypePolicy;
use App\Policies\GeneralSettingPolicy;
use App\Policies\Registers\RegistersTypeFieldsPolicy;
use App\Policies\Registers\RegistersTypePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Update `Activity::class` with the one defined in `config/activitylog.php`
        Activity::class => ActivityPolicy::class,
        GeneralSetting::class => GeneralSettingPolicy::class,
        RegistersType::class => RegistersTypePolicy::class,
        DocumentsType::class => DocumentsTypePolicy::class,
        RegistersTypeFields::class => RegistersTypeFieldsPolicy::class,

    ];
    //...
}
