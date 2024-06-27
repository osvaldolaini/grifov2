<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();

            $table->string('cellphone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->string('cpf_or_cnpj')->nullable();

            $table->string('postal_code')->nullable();
            $table->string('number')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('complement')->nullable();
            $table->string('logo_path', 2048)->nullable();
            $table->text('site_description')->nullable();
            $table->string('theme_color')->nullable();
            $table->string('support_email')->nullable();
            $table->string('support_phone')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->string('posthog_html_snippet')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->json('seo_metadata')->nullable();
            $table->json('email_settings')->nullable();
            $table->string('email_from_address')->nullable();
            $table->string('email_from_name')->nullable();
            $table->json('social_network')->nullable();
            $table->json('more_configs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
