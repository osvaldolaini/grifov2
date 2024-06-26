<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Filament\GeneralSettings\Forms\AddressFieldsForm;
use App\Filament\GeneralSettings\Forms\AnalyticsFieldsForm;
use App\Filament\GeneralSettings\Forms\ApplicationFieldsForm;
use App\Filament\GeneralSettings\Forms\CustomForms;
use App\Filament\GeneralSettings\Forms\EmailFieldsForm;
use App\Filament\GeneralSettings\Forms\ImagesFieldsForm;
use App\Filament\GeneralSettings\Forms\SeoFieldsForm;
use App\Filament\GeneralSettings\Forms\SocialNetworkFieldsForm;
use App\Filament\GeneralSettings\Helpers\EmailDataHelper;
use App\Filament\GeneralSettings\Mail\TestMail;
use App\Models\GeneralSetting;
use App\Filament\GeneralSettings\Services\MailSettingsService;

class GeneralSettings extends Page
{
    use HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static string $view = 'filament.pages.general-settings';

    protected static ?int $navigationSort = -2;

    public static function getNavigationLabel(): string
    {
        return __('General');
    }

    public static function getNavigationGroup(): string
    {
        return __('Settings');
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->data = GeneralSetting::first()?->toArray();
        $this->data = $this->data ?: [];
        $this->data['seo_description'] = $this->data['seo_description'] ?? '';
        $this->data['seo_preview'] = $this->data['seo_preview'] ?? '';
        $this->data['theme_color'] = $this->data['theme_color'] ?? '';
        $this->data['seo_metadata'] = $this->data['seo_metadata'] ?? [];
        $this->data = EmailDataHelper::getEmailConfigFromDatabase($this->data);
    }

    public function form(Form $form): Form
    {
        $arrTabs = [];

        if (config('filament-general-settings.show_application_tab')) {
            $arrTabs[] = Tabs\Tab::make('Application Tab')
                ->label(__('filament-general-settings::default.application'))
                ->icon('heroicon-o-tv')
                ->schema(ApplicationFieldsForm::get())
                ->columns(3);
        }
        if (config('filament-general-settings.show_images_tab')) {
            $arrTabs[] = Tabs\Tab::make('Images Tab')
                ->label(__('filament-general-settings::default.images'))
                ->icon('heroicon-o-photo')
                ->schema(ImagesFieldsForm::get())
                ->columns(3);
        }
        if (config('filament-general-settings.show_address_tab')) {
            $arrTabs[] = Tabs\Tab::make('Address Tab')
                ->label(__('filament-general-settings::default.address'))
                ->icon('heroicon-o-map-pin')
                ->schema(AddressFieldsForm::get())
                ->columns(3);
        }


        if (config('filament-general-settings.show_analytics_tab')) {
            $arrTabs[] = Tabs\Tab::make('Analytics Tab')
                ->label(__('filament-general-settings::default.analytics'))
                ->icon('heroicon-o-globe-alt')
                ->schema(AnalyticsFieldsForm::get());
        }

        if (config('filament-general-settings.show_seo_tab')) {
            $arrTabs[] = Tabs\Tab::make('Seo Tab')
                ->label(__('filament-general-settings::default.seo'))
                ->icon('heroicon-o-window')
                ->schema(SeoFieldsForm::get($this->data))
                ->columns(1);
        }

        if (config('filament-general-settings.show_email_tab')) {
            $arrTabs[] = Tabs\Tab::make('Email Tab')
                ->label(__('filament-general-settings::default.email'))
                ->icon('heroicon-o-envelope')
                ->schema(EmailFieldsForm::get())
                ->columns(3);
        }

        if (config('filament-general-settings.show_social_networks_tab')) {
            $arrTabs[] = Tabs\Tab::make('Social Network Tab')
                ->label(__('filament-general-settings::default.social_networks'))
                ->icon('heroicon-o-heart')
                ->schema(SocialNetworkFieldsForm::get())
                ->columns(2)
                ->statePath('social_network');
        }

        if (config('filament-general-settings.show_custom_tabs')) {
            foreach (config('filament-general-settings.custom_tabs') as $key => $customTab) {
                $arrTabs[] = Tabs\Tab::make($customTab['label'])
                    ->label(__($customTab['label']))
                    ->icon($customTab['icon'])
                    ->schema(CustomForms::get($customTab['fields']))
                    ->columns($customTab['columns'])
                    ->statePath('more_configs');
            }
        }

        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs($arrTabs),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('Save')
                ->label(__('filament-general-settings::default.save'))
                ->color('primary')
                ->submit('Update'),
        ];
    }

    public function update(): void
    {
        $data = $this->form->getState();
        $data = EmailDataHelper::setEmailConfigToDatabase($data);
        $data = $this->clearVariables($data);

        GeneralSetting::updateOrCreate([], $data);
        Cache::forget('general_settings');

        $this->successNotification(__('filament-general-settings::default.settings_saved'));
        redirect(request()?->header('Referer'));
    }

    private function clearVariables(array $data): array
    {
        unset(
            $data['seo_preview'],
            $data['seo_description'],
            $data['default_email_provider'],
            $data['smtp_host'],
            $data['smtp_port'],
            $data['smtp_encryption'],
            $data['smtp_timeout'],
            $data['smtp_username'],
            $data['smtp_password'],
            $data['mailgun_domain'],
            $data['mailgun_secret'],
            $data['mailgun_endpoint'],
            $data['postmark_token'],
            $data['amazon_ses_key'],
            $data['amazon_ses_secret'],
            $data['amazon_ses_region'],
            $data['mail_to'],
        );

        return $data;
    }

    public function sendTestMail(MailSettingsService $mailSettingsService): void
    {
        $data = $this->form->getState();
        $email = $data['mail_to'];

        $settings = $mailSettingsService->loadToConfig($data);

        try {
            Mail::mailer($settings['default_email_provider'])
                ->to($email)
                ->send(new TestMail([
                    'subject' => 'This is a test email to verify SMTP settings',
                    'body' => 'This is for testing email using smtp.',
                ]));
        } catch (\Exception $e) {
            $this->errorNotification(__('filament-general-settings::default.test_email_error'), $e->getMessage());

            return;
        }

        $this->successNotification(__('filament-general-settings::default.test_email_success') . $email);
    }

    private function successNotification(string $title): void
    {
        Notification::make()
            ->title($title)
            ->success()
            ->send();
    }

    private function errorNotification(string $title, string $body): void
    {
        Log::error('[EMAIL] ' . $body);

        Notification::make()
            ->title($title)
            ->danger()
            ->body($body)
            ->send();
    }
}
