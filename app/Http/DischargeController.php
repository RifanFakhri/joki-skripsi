<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDF;

class DischargeController extends Controller
{
    private $apiUrl = 'http://localhost/api/dummy_data_dc_new'; // ganti sesuai API kamu

    public function index()
    {
        $response = Http::get($this->apiUrl);
        $data = $response->json();

        return view('dashboard', ['data' => $data]);
    }

    public function edit($id)
    {
        $response = Http::get("$this->apiUrl/$id");
        $item = $response->json();

        return view('edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        Http::put("$this->apiUrl/$id", [
            'no_container' => $request->no_container,
            'vessel_name' => $request->vessel_name,
            'voyage' => $request->voyage,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data berhasil diperbarui!');
    }

    public function confirm($id)
    {
        Http::post("$this->apiUrl/$id/confirm", [
            'status' => 'Sudah Gate Out',
            'confirmed_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Container berhasil dikonfirmasi!');
    }

    public function print($id)
    {
        $response = Http::get("$this->apiUrl/$id");
        $item = $response->json();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('print', compact('item'));
        return $pdf->stream('discharge_card_'.$item['no_container'].'.pdf');
    }
}
