<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class DischargingController extends Controller
{
    public function index()
    {
        if (!Session::has('username')) {
            return redirect()->route('login');
        }

        $data = DB::table('dummy_data_dc_new')
            ->whereNotNull('TGL_GTI')
            ->orderBy('TGL_GTI', 'DESC')
            ->get() ?? collect([]);

        $gateout = DB::table('dc_gateout')
            ->orderBy('id', 'DESC')
            ->get() ?? collect([]);

        return view('dischargingcardsystem', compact('data', 'gateout'));
    }

    public function editForm($NO_CTR)
    {
        $data = DB::table('dummy_data_dc_new')->where('NO_CTR', $NO_CTR)->first();

        if (!$data) {
            return redirect()->route('discharging')->with('error', 'Data tidak ditemukan.');
        }

        return view('edit', compact('data'));
    }

    public function edit(Request $request, $NO_CTR)
    {
        DB::table('dummy_data_dc_new')
            ->where('NO_CTR', $NO_CTR)
            ->update([
                'VOYAGE_NO'   => $request->voyage,
                'NM_KAPAL'    => $request->nama_kapal,
                'NM_AGEN'     => $request->nama_agen,
                'SIZE_CTR'    => $request->ukuran,
                'TIPE_CTR'    => $request->tipe,
                'BERAT_CTR'   => $request->berat,
                'Depo_Tujuan' => $request->depo,
                'No_Lambung'  => $request->nama_truck,
                'Nopol'       => $request->no_polisi,
            ]);

        return redirect()->route('discharging')->with('success', 'Data berhasil diperbarui!');
    }

    public function gateout($NO_CTR)
    {
        $row = DB::table('dummy_data_dc_new')->where('NO_CTR', $NO_CTR)->first();

        if (!$row) {
            return redirect()->route('discharging')->with('error', 'Data tidak ditemukan.');
        }

        // Insert ke tabel dc_gateout
        DB::table('dc_gateout')->insert([
            'NM_SERVIS'       => $row->NM_SERVIS ?? null,
            'NO_CTR'          => $row->NO_CTR,
            'VOYAGE_NO'       => $row->VOYAGE_NO ?? null,
            'NM_KAPAL'        => $row->NM_KAPAL,
            'VOYAGE_NO_PLG'   => $row->VOYAGE_NO_PLG ?? null,
            'NM_AGEN'         => $row->NM_AGEN ?? null,
            'SIZE_CTR'        => $row->SIZE_CTR ?? null,
            'TIPE_CTR'        => $row->TIPE_CTR ?? null,
           'STATUS_VALUE' => $row->STATUS_VALUE,
            'STATUS_GATEOUT'  => 'Sudah',      // Status gate out baru
            'BERAT_CTR'       => $row->BERAT_CTR ?? null,
            'POL'             => $row->POL ?? null,
            'POD'             => $row->POD ?? null,
            'Depo_Tujuan'     => $row->Depo_Tujuan ?? null,
            'Nopol'           => $row->Nopol ?? null,
            'No_Lambung'      => $row->No_Lambung ?? null,
            'Keterangan'      => $row->Keterangan ?? null,
            'TGL_GTI'         => $row->TGL_GTI ?? now(),
            'tgl_gateout'     => now(),
        ]);

        // Hapus dari tabel dummy
        DB::table('dummy_data_dc_new')->where('NO_CTR', $NO_CTR)->delete();

        return redirect()->route('discharging')->with('success', 'Gate Out berhasil. Data dipindahkan!');
    }

    public function print($NO_CTR)
    {
        $data = DB::table('dummy_data_dc_new')->where('NO_CTR', $NO_CTR)->first();

        if (!$data) {
            return redirect()->route('discharging')->with('error', 'Data tidak ditemukan.');
        }

        return view('print', compact('data'));
    }

    public function exportExcel()
    {
        $data = DB::table('dc_gateout')->orderBy('id', 'DESC')->get();
        $filename = "gateout_data.xls";

        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$filename"
        ];

        $output = "<table border='1'>
            <tr>
                <th>No</th>
                <th>No Container</th>
                <th>Kapal</th>
                <th>Agen</th>
                <th>Truck</th>
                <th>Nopol</th>
                <th>Depo</th>
                <th>Tanggal</th>
            </tr>";

        foreach ($data as $i => $row) {
            $output .= "<tr>
                <td>".($i+1)."</td>
                <td>$row->NO_CTR</td>
                <td>$row->NM_KAPAL</td>
                <td>$row->NM_AGEN</td>
                <td>$row->No_Lambung</td>
                <td>$row->Nopol</td>
                <td>$row->Depo_Tujuan</td>
                <td>$row->tgl_gateout</td>
            </tr>";
        }

        $output .= "</table>";
        return response($output, 200, $headers);
    }

    

    public function sendPdfEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $data = DB::table('dc_gateout')
        ->orderBy('id', 'DESC')
        ->get();

    $pdf = Pdf::loadView('gateout_pdf', compact('data'));

    Mail::send([], [], function ($message) use ($request, $pdf, $data) {

        $totalContainer = $data->count();

        $message->to($request->email)
                ->subject('Laporan Gate Out Container - SANDRA System')
                ->html("
                <h2>SANDRA System</h2>

                <p>Yth. Bapak/Ibu,</p>

                <p>
                    Berikut kami sampaikan laporan aktivitas
                    Gate Out Container yang dihasilkan oleh
                    sistem SANDRA.
                </p>

                <table border='1' cellpadding='8'>
                    <tr>
                        <td><b>Tanggal Kirim</b></td>
                        <td>".now()->format('d-m-Y H:i:s')."</td>
                    </tr>
                    <tr>
                        <td><b>Total Data Gate Out</b></td>
                        <td>".$totalContainer." Container</td>
                    </tr>
                </table>

                <br>

                <p>
                    Detail lengkap terdapat pada file PDF
                    yang terlampir pada email ini.
                </p>

                <br>

                <b>SANDRA System</b>
                ");

        $message->attachData(
            $pdf->output(),
            'gateout_data.pdf',
            [
                'mime' => 'application/pdf'
            ]
        );
    });

    return response()->json([
        'message' => 'PDF berhasil dikirim ke email.'
    ]);
}
}

