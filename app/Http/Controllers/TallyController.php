<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TallyController extends Controller
{
    public function pilihKapal()
    {
        if (!Session::has('username')) {
            return redirect()->route('login');
        }

        $kapal = DB::table('dummy_data_dc_new')
            ->select('NM_KAPAL')
            ->distinct()
            ->get();

        $hmc = [
            'B-01','B-02','B-03','B-04','B-05','B-06','B-07','B-08','B-09',
            'B-10','B-11','B-12','B-13','B-14','B-15','B-16','B-17','B-18'
        ];

        return view('pilih-kapal', compact('kapal', 'hmc'));
    }

    public function setKapal(Request $request)
    {
        Session::put('kapal', $request->kapal);
        Session::put('hmc', $request->hmc);

        return redirect()->route('tally.konfirmasi');
    }

    public function index()
    {
        if (!Session::has('username')) {
            return redirect()->route('login');
        }

        if (!Session::has('kapal')) {
            return redirect()->route('tally.pilihKapal');
        }

        return view('tally-konfirmasi');
    }

    public function getData(Request $request)
{
    $row = DB::table('dummy_data_dc_new')
        ->where('NO_CTR', trim($request->no))
        ->first();

    if ($row) {
        return response()->json([
            'status' => 'found',
            'row' => $row
        ]);
    }

    return response()->json([
        'status' => 'not_found'
    ]);
}



    public function submit(Request $request)
    {
        $kapal = Session::get('kapal');
        $alat  = Session::get('hmc');
        $operator = Session::get('username');

        // Ambil data container dari dummy_data_dc_new
        $row = DB::table('dummy_data_dc_new')
            ->where('NO_CTR', trim($request->no_container))
            ->first();

        if (!$row) {
            return redirect()->back()->with('error', 'Data container tidak ditemukan!');
        }

        // AUTO FORMAT & VALIDASI NO LAMBUNG (Sesuai trigger DB trg_check_no_lambung)
        $kapal_val = strtoupper($kapal);
        
        // Hapus spasi dan jadikan huruf besar (case-insensitive & space-insensitive)
        $lambung_val = strtoupper(str_replace(' ', '', $request->no_lambung));

        // Auto-fix jika user hanya mengetik angka (misal "13" -> "G13")
        if (str_contains($kapal_val, 'GUHI MAS') && preg_match('/^[0-9]+$/', $lambung_val)) {
            $lambung_val = 'G' . $lambung_val;
        } elseif (str_contains($kapal_val, 'TANTO') && preg_match('/^[0-9]+$/', $lambung_val)) {
            $lambung_val = 'T' . $lambung_val;
        } elseif (str_contains($kapal_val, 'MERATUS') && preg_match('/^[0-9]+$/', $lambung_val)) {
            $lambung_val = 'M' . $lambung_val;
        }

        // Validasi final
        if (str_contains($kapal_val, 'GUHI MAS') && !preg_match('/^G[0-9]+$/', $lambung_val)) {
            return redirect()->back()->with('error', 'No Lambung untuk kapal GUHI MAS harus diawali huruf G lalu diikuti angka (contoh: G13)');
        }
        if (str_contains($kapal_val, 'TANTO') && !preg_match('/^T[0-9]+$/', $lambung_val)) {
            return redirect()->back()->with('error', 'No Lambung untuk kapal TANTO harus diawali huruf T lalu diikuti angka (contoh: T12)');
        }
        if (str_contains($kapal_val, 'MERATUS') && !preg_match('/^M[0-9]+$/', $lambung_val)) {
            return redirect()->back()->with('error', 'No Lambung untuk kapal MERATUS harus diawali huruf M lalu diikuti angka (contoh: M09)');
        }

        // Update dummy_data_dc_new
        DB::table('dummy_data_dc_new')
        ->where('NO_CTR', trim($request->no_container))
        ->update([
            'No_Lambung'    => $lambung_val,
            'Keterangan'    => $request->keterangan,
            'TGL_GTI'       => now(),
            'NM_KAPAL'      => $kapal,
            'alat'          => $alat,
            'operator'      => $operator,
        ]);



        return redirect()->route('discharging')->with('success', 'Data berhasil dikonfirmasi & masuk Discharging!');
    }

    // =========================
    // AUTOCOMPLETE API
    // =========================
    public function cariContainer(Request $request)
    {
        $q = $request->q;
        $data = DB::table('dummy_data_dc_new')
            ->where('NO_CTR', 'like', "%{$q}%")
            ->pluck('NO_CTR');
        return response()->json($data);
    }

    public function cariLambung(Request $request)
    {
        $q = $request->q;
        $data = DB::table('dummy_data_dc_new')
            ->where('No_Lambung', 'like', "%{$q}%")
            ->pluck('No_Lambung');
        return response()->json($data);
    }
}
