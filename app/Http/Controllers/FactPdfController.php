<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Facts\Facts;
use App\Models\GeneralSetting;

class FactPdfController extends Controller
{
    public function __invoke(Facts $fact)
    {
        // dd(GeneralSetting::first()->get())
        // dd($fact);
        return Pdf::loadView('pdf/facts', [
            'record' => $fact,
            'config' => GeneralSetting::first()
        ])
            ->download($fact->id . '.pdf');
    }
}
