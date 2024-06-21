<?php

namespace App\Filament\Pages;

use App\Models\Configurations;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    protected static ?string $navigationGroup = 'Settings';

    public static function getNavigationGroup(): string
    {
        return __('Settings');
    }
    public static function getNavigationLabel(): string
    {
        return __('Configurations');
    }

    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];
    public  $configs;

    public function mount(): void
    {
        $this->configs = Configurations::first();
        // dd(Configurations::all());
        $this->form->fill($this->configs->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),
                MarkdownEditor::make('content'),
                // ...
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        // dd($this->form->getState());
        Configurations::updateOrCreate(
            [
                'id' => 1
            ],
            $this->form->getState()
        );
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
}
