<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Cep;
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
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

class GeneralSettings extends Page
{
    use HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static string $view = 'filament.pages.general-settings';

    protected static ?int $navigationSort = -2;

    public static function getLabel(): string
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

        $arrTabs[] = Tabs\Tab::make('Application Tab')
            ->label('Gerais')
            ->icon('heroicon-o-tv')
            ->schema(ApplicationFieldsForm::get())
            ->columns(3);

        $arrTabs[] = Tabs\Tab::make('Images Tab')
            ->label(__('Imagens'))
            ->icon('heroicon-o-photo')
            ->schema([
                FileUpload::make('logo')
                    ->multiple()
                    ->directory('logos')
                    ->columnSpanFull()
                    ->label(__('Imagens')),
            ])
            ->columns(3);

        $arrTabs[] = Tabs\Tab::make('Address Tab')
            ->label('Endereço')
            ->icon('heroicon-o-map-pin')
            ->schema([
                Cep::make('postal_code')
                    ->viaCep(
                        mode: 'suffix',
                        errorMessage: 'CEP inválido.',
                        setFields: [
                            'address' => 'logradouro',
                            'number' => 'numero',
                            'complement' => 'complemento',
                            'district' => 'bairro',
                            'city' => 'localidade',
                            'state' => 'uf'
                        ]
                    )->live(onBlur: true)->label(__('postal_code')),

                TextInput::make('address')->label(__('address')),
                TextInput::make('number')->label(__('number')),
                TextInput::make('complement')->label(__('complement')),
                TextInput::make('district')->label(__('district')),
                TextInput::make('city')->label(__('city')),
                TextInput::make('state')->label(__('state')),
            ])
            ->columns(3);

        $arrTabs[] = Tabs\Tab::make('Analytics Tab')
            ->label('Dados Analíticos')
            ->icon('heroicon-o-globe-alt')
            ->schema(AnalyticsFieldsForm::get());

        $arrTabs[] = Tabs\Tab::make('Seo Tab')
            ->label('SEO')
            ->icon('heroicon-o-window')
            ->schema(SeoFieldsForm::get($this->data))
            ->columns(1);

        $arrTabs[] = Tabs\Tab::make('Email Tab')
            ->label('Email')
            ->icon('heroicon-o-envelope')
            ->schema(EmailFieldsForm::get())
            ->columns(3);

        $arrTabs[] = Tabs\Tab::make('Social Network Tab')
            ->label('Redes Sociais')
            ->icon('heroicon-o-heart')
            ->schema(SocialNetworkFieldsForm::get())
            ->columns(2)
            ->statePath('social_network');

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
                ->label(__('save'))
                ->color('primary')
                ->submit('Update'),
        ];
    }

    public function update(): void
    {
        $data = $this->form->getState();
        $data = EmailDataHelper::setEmailConfigToDatabase($data);
        $data = $this->clearVariables($data);

        $general = GeneralSetting::updateOrCreate([], $data);
        foreach ($general->logo as $logo) {
            $this->logo($logo);
            break;
        }

        Cache::forget('general_settings');

        $this->successNotification(__('settings_saved'));
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
            $this->errorNotification(__('test_email_error'), $e->getMessage());

            return;
        }

        $this->successNotification(__('test_email_success') . $email);
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
    /**Logo e favicons */
    public static function logo($path)
    {
        $path = 'storage/' . $path;
        // create image manager with desired driver
        $manager = new ImageManager(new Driver());
        // read image from file system
        $image = $manager->read($path);
        // $image = ImageManager::imagick()->read('images/example.jpg');
        // save modified image in new format
        $image->toPng()->save('storage/logos/logo.png');
        $image->toWebp()->save('storage/logos/logo.webp');
        $image->scale(width: 300);
        // Logos footer e Header
        $footer = $manager->read($path);
        $footer->scale(width: 300);
        $footer->toPng()->save('storage/logos/logo-footer.png');
        $footer->toWebp()->save('storage/logos/logo-footer.webp');

        $header = $manager->read($path);
        $header->scale(width: 130);
        $header->toPng()->save('storage/logos/logo-header.png');
        $header->toWebp()->save('storage/logos/logo-header.webp');

        if (Storage::directoryMissing('public/favicons')) {
            Storage::makeDirectory('public/favicons');
        }
        // Favicons
        $sizes = [
            [16, 'favicon-16x16'],
            [32, 'favicon-32x32'],
            [48, 'favicon'],
            [96, 'favicon-96x96'],
            [70, 'ms-icon-70x70'],
            [144, 'ms-icon-144x144'],
            [150, 'ms-icon-150x150'],
            [310, 'ms-icon-310x310'],
            [192, 'android-chrome-192x192'],
            [512, 'android-chrome-512x512'],
            [36, 'android-icon-36x36'],
            [48, 'android-icon-48x48'],
            [72, 'android-icon-72x72'],
            [96, 'android-icon-96x96'],
            [144, 'android-icon-144x144'],
            [192, 'android-icon-192x192'],
            [57, 'apple-icon-57x57'],
            [60, 'apple-icon-60x60'],
            [72, 'apple-icon-72x72'],
            [76, 'apple-icon-76x76'],
            [114, 'apple-icon-114x114'],
            [120, 'apple-icon-120x120'],
            [144, 'apple-icon-144x144'],
            [152, 'apple-icon-152x152'],
            [180, 'apple-icon-180x180'],
            [192, 'apple-icon'],
            [192, 'apple-icon-precomposed'],
            [180, 'apple-touch-icon'],
        ];
        foreach ($sizes as $fav) {
            $favicon = $manager->read($path);
            $favicon->scale(width: $fav[0]);
            $favicon->toPng()->save('storage/favicons/' . $fav[1] . '.png');
        }
    }
}
