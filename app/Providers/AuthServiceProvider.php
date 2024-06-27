<?php

namespace App\Providers;

use App\Policies\ActivityPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use App\Models\GeneralSetting;
use App\Policies\GeneralSettingPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Update `Activity::class` with the one defined in `config/activitylog.php`
        Activity::class => ActivityPolicy::class,
        GeneralSetting::class => GeneralSettingPolicy::class,
    ];
    //...
}
