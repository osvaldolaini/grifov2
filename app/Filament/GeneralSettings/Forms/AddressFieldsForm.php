<?php

namespace App\Filament\GeneralSettings\Forms;

use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Cep;

class AddressFieldsForm
{
    public static function get(): array
    {
        return [
            Cep::make('postal_code')
                ->viaCep(
                    mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                    errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.

                    /**
                     * Other form fields that can be filled by ViaCep.
                     * The key is the name of the Filament input, and the value is the ViaCep attribute that corresponds to it.
                     * More information: https://viacep.com.br/
                     */
                    setFields: [
                        'address' => 'logradouro',
                        'number' => 'numero',
                        'complement' => 'complemento',
                        'district' => 'bairro',
                        'city' => 'localidade',
                        'state' => 'uf'
                    ]
                )->live(onBlur: true)->label(__('filament-general-settings::default.postal_code')),

            TextInput::make('address')->label(__('filament-general-settings::default.address')),
            TextInput::make('number')->label(__('filament-general-settings::default.number')),
            TextInput::make('complement')->label(__('filament-general-settings::default.complement')),
            TextInput::make('district')->label(__('filament-general-settings::default.district')),
            TextInput::make('city')->label(__('filament-general-settings::default.city')),
            TextInput::make('state')->label(__('filament-general-settings::default.state')),

        ];
    }
}
