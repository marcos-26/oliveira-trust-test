<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Upload;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:csv,xlsx',
    ]);

    $file = $request->file('file');
    $filename = $file->getClientOriginalName();

    // Verifica se o arquivo já foi enviado
    if (Upload::where('filename', $filename)->exists()) {
        return response()->json(['message' => 'Arquivo já enviado anteriormente'], 400);
    }

    // Salva o upload no banco
    $upload = Upload::create([
        'filename' => $filename,
        'reference_date' => now()->format('Y-m-d'),
        'uploaded_at' => now(),
    ]);

    // Processa o conteúdo do arquivo
    $data = [];
    if ($file->getClientOriginalExtension() === 'csv') {
        $rows = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data[] = array_combine($header, $row);
        }
    } else {
        // Processa Excel (usando pacote como PhpSpreadsheet)
    }

    // Insere no banco
    File::insert($data);

    return response()->json(['message' => 'Upload realizado com sucesso']);
}

public function history(Request $request)
{
    $query = Upload::query();

    if ($request->has('filename')) {
        $query->where('filename', $request->filename);
    }

    if ($request->has('reference_date')) {
        $query->where('reference_date', $request->reference_date);
    }

    return response()->json($query->get());
}


public function search(Request $request)
{
    $query = File::query();

    if ($request->has('TckrSymb')) {
        $query->where('TckrSymb', $request->TckrSymb);
    }

    if ($request->has('RptDt')) {
        $query->where('RptDt', $request->RptDt);
    }

    return response()->json($query->paginate(20));
}

}
