<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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
        ->get();

    $gateout = DB::table('dc_gateout')
        ->orderBy('id', 'DESC')
        ->get();

    // Ambil role user yang login
    $role = Session::get('role');

    return view('dischargingcardsystem', compact(
        'data',
        'gateout',
        'role'
    ));
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

        $cek = DB::table('dc_gateout')
            ->where('NO_CTR', $NO_CTR)
            ->first();

        if ($cek && $cek->STATUS_GATEOUT === 'Sudah') {
            return redirect()->route('discharging')
                ->with('error', 'Container sudah pernah Gate Out');
        }

        if ($cek) {
            // Update jika data sudah ada (biasanya karena sudah diinsert oleh Tally dengan status 'Belum')
            DB::table('dc_gateout')->where('NO_CTR', $NO_CTR)->update([
                'NM_SERVIS'       => $row->NM_SERVIS ?? null,
                'VOYAGE_NO'       => $row->VOYAGE_NO ?? null,
                'NM_KAPAL'        => $row->NM_KAPAL,
                'VOYAGE_NO_PLG'   => $row->VOYAGE_NO_PLG ?? null,
                'NM_AGEN'         => $row->NM_AGEN ?? null,
                'SIZE_CTR'        => $row->SIZE_CTR ?? null,
                'TIPE_CTR'        => $row->TIPE_CTR ?? null,
                'STATUS_VALUE'    => $row->STATUS_VALUE ?? '-',
                'STATUS_GATEOUT'  => 'Sudah',
                'BERAT_CTR'       => $row->BERAT_CTR ?? null,
                'POL'             => $row->POL ?? null,
                'POD'             => $row->POD ?? null,
                'Depo_Tujuan'     => $row->Depo_Tujuan ?? null,
                'Nopol'           => $row->Nopol ?? null,
                'No_Lambung'      => $row->No_Lambung ?? null,
                'Keterangan'      => $row->Keterangan ?? null,
                'alat'            => $row->alat ?? null,
                'operator'        => $row->operator ?? null,
                'tgl_gateout'     => now(),
            ]);
        } else {
            // Insert ke tabel dc_gateout jika belum ada
            DB::table('dc_gateout')->insert([
                'NM_SERVIS'       => $row->NM_SERVIS ?? null,
                'NO_CTR'          => $row->NO_CTR,
                'VOYAGE_NO'       => $row->VOYAGE_NO ?? null,
                'NM_KAPAL'        => $row->NM_KAPAL,
                'VOYAGE_NO_PLG'   => $row->VOYAGE_NO_PLG ?? null,
                'NM_AGEN'         => $row->NM_AGEN ?? null,
                'SIZE_CTR'        => $row->SIZE_CTR ?? null,
                'TIPE_CTR'        => $row->TIPE_CTR ?? null,
                'STATUS_VALUE'    => $row->STATUS_VALUE ?? '-',
                'STATUS_GATEOUT'  => 'Sudah',
                'BERAT_CTR'       => $row->BERAT_CTR ?? null,
                'POL'             => $row->POL ?? null,
                'POD'             => $row->POD ?? null,
                'Depo_Tujuan'     => $row->Depo_Tujuan ?? null,
                'Nopol'           => $row->Nopol ?? null,
                'No_Lambung'      => $row->No_Lambung ?? null,
                'Keterangan'      => $row->Keterangan ?? null,
                'alat'            => $row->alat ?? null,
                'operator'        => $row->operator ?? null,
                'TGL_GTI'         => $row->TGL_GTI ?? now(),
                'tgl_gateout'     => now(),
            ]);
        }

        // Hapus dari tabel dummy
        DB::table('dummy_data_dc_new')->where('NO_CTR', $NO_CTR)->delete();

        return redirect()->route('discharging')->with('success', 'Gate Out berhasil. Data dipindahkan!');
    }

    public function print($NO_CTR)
{
    $data = DB::table('dummy_data_dc_new')
        ->where('NO_CTR', $NO_CTR)
        ->first();

    if (!$data) {
        return redirect()->route('discharging')
            ->with('error', 'Data tidak ditemukan.');
    }

    Carbon::setLocale('id');

    $printTime = Carbon::now('Asia/Jakarta');

    return response()
        ->view('print', [
            'data' => $data,
            'printTime' => $printTime
        ])
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
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

    $query = DB::table('dc_gateout');

    if ($request->filled('tanggal')) {
        $query->whereDate('tgl_gateout', $request->tanggal);
    }

    if ($request->filled('kapal')) {
        $query->where('NM_KAPAL', $request->kapal);
    }

    if ($request->filled('depo')) {
        $query->where('Depo_Tujuan', $request->depo);
    }

    if ($request->filled('text')) {

        $text = $request->text;

        $query->where(function ($q) use ($text) {

            $q->where('NO_CTR', 'like', "%{$text}%")
              ->orWhere('No_Lambung', 'like', "%{$text}%")
              ->orWhere('Nopol', 'like', "%{$text}%");

        });
    }

    $data = $query
        ->orderBy('tgl_gateout', 'DESC')
        ->get();

    Carbon::setLocale('id');

    $tanggalLaporan = Carbon::now('Asia/Jakarta');

    $pdf = Pdf::loadView('gateout_pdf', [
        'data' => $data,
        'tanggalLaporan' => $tanggalLaporan
    ]);

    Mail::send([], [], function ($message) use ($request, $pdf, $data, $tanggalLaporan) {

        $message->to($request->email)
            ->subject('Laporan Gate Out Kontainer PT XYZ')
            ->html('

<p>Yth. Bapak/Ibu,</p>

<p>
Email ini merupakan pemberitahuan otomatis dari
<strong>Smart Discharging and Recording System (SANDRA)</strong>
PT XYZ.
</p>

<p>
Bersama email ini disampaikan dokumen
<strong>Laporan Aktivitas Gate Out Kontainer</strong>
yang telah dihasilkan secara otomatis berdasarkan data operasional
yang tersimpan pada sistem setelah proses Gate Out selesai dilakukan.
</p>

<p>
Laporan terlampir merupakan hasil rekapitulasi data sesuai parameter
atau filter yang dipilih pada saat proses pembuatan laporan.
Dokumen ini dapat digunakan sebagai bahan monitoring operasional,
pelaporan kegiatan, dokumentasi, serta arsip digital perusahaan.
</p>

<table border="1" cellpadding="7" cellspacing="0" style="border-collapse:collapse;margin-top:15px;">

<tr>
<td width="180"><strong>Nomor Dokumen</strong></td>
<td>GO/'.$tanggalLaporan->format('YmdHis').'</td>
</tr>

<tr>
<td><strong>Tanggal Penerbitan</strong></td>
<td>'.$tanggalLaporan->translatedFormat('d F Y').'</td>
</tr>

<tr>
<td><strong>Waktu Penerbitan</strong></td>
<td>'.$tanggalLaporan->format('H:i:s').' WIB</td>
</tr>

<tr>
<td><strong>Total Data Gate Out</strong></td>
<td>'.$data->count().' Kontainer</td>
</tr>

</table>

<p style="margin-top:18px;">
Dokumen laporan dalam format PDF telah dilampirkan pada email ini.
Seluruh informasi yang tercantum di dalam laporan bersumber dari basis data
operasional <strong>SANDRA (Smart Discharging and Recording System)</strong>
PT XYZ.
</p>

<p>
Apabila terdapat perbedaan informasi pada dokumen yang telah dicetak
atau disimpan sebelumnya, maka data yang tersimpan pada sistem operasional
SANDRA merupakan sumber informasi utama (source of truth) yang digunakan
sebagai acuan perusahaan.
</p>

<hr>

<p style="font-size:12px;color:#666;">
Email ini dibuat dan dikirim secara otomatis oleh
<strong>Smart Discharging and Recording System (SANDRA)</strong>
PT XYZ.<br>
Mohon untuk tidak membalas email ini karena kotak masuk tidak dipantau.
Apabila memerlukan informasi lebih lanjut, silakan menghubungi Administrator
atau petugas operasional yang berwenang.
</p>

');
        $message->attachData(
            $pdf->output(),
            'Laporan_Gate_Out.pdf',
            [
                'mime' => 'application/pdf'
            ]
        );
    });

    return response()->json([
        'message' => 'PDF berhasil dikirim ke email.'
    ]);
}

public function exportPDF(Request $request)
{
    $query = DB::table('dc_gateout');

    if ($request->filled('tanggal')) {
        $query->whereDate('tgl_gateout', $request->tanggal);
    }

    if ($request->filled('kapal')) {
        $query->where('NM_KAPAL', $request->kapal);
    }

    if ($request->filled('depo')) {
        $query->where('Depo_Tujuan', $request->depo);
    }

    if ($request->filled('text')) {

        $text = $request->text;

        $query->where(function ($q) use ($text) {

            $q->where('NO_CTR', 'like', "%{$text}%")
              ->orWhere('No_Lambung', 'like', "%{$text}%")
              ->orWhere('Nopol', 'like', "%{$text}%");

        });
    }

    $data = $query
        ->orderBy('tgl_gateout', 'DESC')
        ->get();

    Carbon::setLocale('id');

    $tanggalLaporan = Carbon::now('Asia/Jakarta');

    $pdf = Pdf::loadView('gateout_pdf', [
        'data' => $data,
        'tanggalLaporan' => $tanggalLaporan
    ]);

    return $pdf->download('Laporan_Gate_Out.pdf');
}
}

