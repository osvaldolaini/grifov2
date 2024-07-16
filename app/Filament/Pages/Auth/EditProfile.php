<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected static string $view = 'filament.pages.auth.edit-profile';
    protected static string $layout = 'filament-panels::components.layout.index';
    public static function getSlug(): string
    {
        return static::$slug ?? 'meus-dados';
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações pessoais')
                    ->aside()
                    ->schema([
                        tabs::make('Tabs')
                            ->columns(6)
                            ->tabs([
                                Tabs\Tab::make('Dados gerais')
                                    ->icon('heroicon-m-bell')
                                    ->schema([
                                        $this->getNameFormComponent()->columnSpan(6),
                                        $this->getEmailFormComponent()->columnSpan(6),
                                        $this->getPasswordFormComponent()->columnSpan(6),
                                        $this->getPasswordConfirmationFormComponent()->columnSpan(6)
                                    ])
                                    ->columnSpan(6),
                                Tabs\Tab::make('Foto do perfil')
                                    ->icon('heroicon-m-photo')
                                    ->schema([
                                        FileUpload::make('avatar_url')
                                            ->avatar()
                                            ->label('Foto')->columnSpan(6),
                                    ]),

                            ])->columnSpanFull()
                    ])
            ]);
    }
}
