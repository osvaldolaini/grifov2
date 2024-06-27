<?php

namespace App\Filament\GeneralSettings\Enums;

use App\Filament\GeneralSettings\Traits\WithOptions;

enum EmailProviderEnum: string
{
    use WithOptions;

    case SMTP = 'SMTP';
    case MAILGUN = 'Mailgun';
    case SES = 'Amazon SES';
    case POSTMARK = 'Postmark';
}
