<?php

namespace App\Http\Controllers;

use App\Models\Documents\Documents;
use App\Models\Facts\Facts;
use App\Models\GeneralSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Registers\Registers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class RegisterPdfController extends Controller
{
    public function __invoke(Registers $register)
    {

        // dd($register);
        $docs = array();
        $documents = Documents::where('palavraChave', 'LIKE', "%$register->id%")->get();

        foreach ($documents as $doc) {
            $docs[] = [
                'id' => $doc->id,
                'assunto' => $doc->assunto,
                'search' => $register->nome,
                'resenha' => $this->search($doc->id, $register->id)
            ];
        }
        // $docs = json_encode($docs);
        // dd($docs);
        $register->enderecos;

        return Pdf::loadView(
            'pdf/registers',
            [
                'record'    => $register,
                'config'    => GeneralSetting::first(),
                'facts'     => Facts::where('palavraChave', 'LIKE', "%$register->id%")->get(),
                'docs'      => json_encode($docs)
            ]
        )
            ->download($register->id . '.pdf');
    }
    public function search($document, $register)
    {

        $searchString = Registers::find($register)->nome;

        $pythonScriptPath = public_path('app.py');
        $path = 'public/docs/' . $document;
        $pdfFiles = Storage::files($path);
        $results = [];

        if (Storage::exists('public/docs/' . $document)) {
            // dd($searchString, $path);
            // Obter todos os arquivos e subdiretórios na pasta
            $files = Storage::allFiles($path);

            // Verificar se a pasta não está vazia
            if (!empty($files)) {
                // dd($searchString, $path);
                // Caminho absoluto para o executável do Python
                $pythonExecutable = "C:\\laragon\\bin\\python\\python-3.10\\python.exe";  // Substitua pelo caminho correto

                foreach ($pdfFiles as $file) {
                    $filepath = Storage::path($file);

                    // Montar o comando para executar o script Python
                    $command = [
                        $pythonExecutable,
                        $pythonScriptPath,
                        $filepath,
                        str_replace("'", "\\'", $searchString),
                    ];

                    // Criar uma nova instância de Process
                    $process = new Process($command);

                    // Iniciar o processo
                    $process->run();

                    // Verificar se houve algum erro na execução do processo
                    if (!$process->isSuccessful()) {
                        throw new ProcessFailedException($process);
                    }

                    // Capturar a saída do processo
                    $output = $process->getOutput();

                    // Tentar decodificar a saída como JSON
                    try {
                        // Limpar a saída para garantir que apenas o JSON seja decodificado
                        $jsonStartPos = strpos($output, '{');
                        $jsonEndPos = strrpos($output, '}');
                        $jsonLength = $jsonEndPos - $jsonStartPos + 1;
                        $jsonOutput = substr($output, $jsonStartPos, $jsonLength);
                        // dd($jsonOutput);
                        // Decodificar o JSON para uma estrutura PHP
                        $data = json_decode($jsonOutput, true);
                        // dd($data);
                        // Verificar se houve erro na decodificação
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            throw new \Exception("Erro ao decodificar JSON: " . json_last_error_msg());
                        }

                        // Processar os dados decodificados
                        $results = $data;
                    } catch (\Exception $e) {
                        Log::error("Erro ao decodificar JSON: " . $e->getMessage());
                    }
                    // dd($this->results);
                    return $results;
                }
            }
        }
    }
}
