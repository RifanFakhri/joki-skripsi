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
        $noCtr = $request->no;
        $noLambung = $request->lambung;

        $row = DB::table('dummy_data_dc_new')
                ->where('NO_CTR', $noCtr)
                ->where('No_Lambung', $noLambung)
                ->first();

        if ($row) {
            return response()->json([
                'status' => 'found',
                'row' => $row
            ]);
        }

        return response()->json(['status' => 'not_found']);
    }

    public function submit(Request $request)
    {
        $kapal = Session::get('kapal');
        $alat  = Session::get('hmc');
        $operator = Session::get('username');

        // Ambil data container dari dummy_data_dc_new
        $row = DB::table('dummy_data_dc_new')
            ->where('NO_CTR', $request->no_container)
            ->first();

        if (!$row) {
            return redirect()->back()->with('error', 'Data container tidak ditemukan!');
        }

        // Update dummy_data_dc_new
        DB::table('dummy_data_dc_new')
            ->where('NO_CTR', $request->no_container)
            ->update([
                'No_Lambung' => $request->no_lambung,
                'Keterangan' => $request->keterangan,
                'TGL_GTI'    => now(),
                'NM_KAPAL'   => $kapal,
                'alat'       => $alat,
                'operator'   => $operator
            ]);

        // Insert ke dc_gateout
        DB::table('dc_gateout')->insert([
            'NO_CTR'          => $request->no_container,
            'No_Lambung'      => $request->no_lambung,
            'NM_KAPAL'        => $kapal,
            'alat'            => $alat,
            'operator'        => $operator,
            'TGL_GTI'         => now(),
            'STATUS_VALUE'    => $row->STATUS_VALUE ?? '-', // Ambil dari database
            'STATUS_GATEOUT'  => 'Belum'                   // Status gate out baru
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
