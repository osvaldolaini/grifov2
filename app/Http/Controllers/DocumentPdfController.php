<?php

namespace App\Http\Controllers;

use App\Models\Documents\Documents;
use Illuminate\Support\Facades\Storage;

class DocumentPdfController extends Controller
{
    public function __invoke(Documents $document)
    {
        if (Storage::exists('public/' . $document->documento)) {
            echo 'aqui';
            return Storage::download('public/' . $document->documento, $document->id . '.pdf');
        } else {
            echo '<script>window.close();</script>';
        }
    }
}
