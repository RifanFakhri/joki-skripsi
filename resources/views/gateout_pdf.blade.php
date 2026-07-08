<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<style>

body{
    font-family:"Times New Roman", serif;
    font-size:12pt;
    margin:40px;
    color:#000;
}

.header{
    text-align:center;
    margin-bottom:20px;
}

.header h2{
    margin:0;
    font-size:18pt;
}

.header h3{
    margin:5px 0;
    font-size:15pt;
}

.header p{
    margin:0;
    font-size:12pt;
}

.info{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
}

.info th,
.info td{
    border:1px solid #000;
    padding:7px;
    text-align:left;
    font-size:12pt;
}

.info th{
    background:#E6E6E6;
    width:22%;
}

.data{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

.data{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
    margin-top:10px;
}

.data th,
.data td{
    border:1px solid #000;
    padding:4px;
    font-size:8pt;
    word-wrap:break-word;
}

.data th{
    background:#D9D9D9;
    text-align:center;
    font-weight:bold;
}

.data td{
    text-align:center;
    vertical-align:middle;
}

.data th{
    background:#D9D9D9;
    text-align:center;
}

.data td{
    text-align:center;
}

.pengantar{
    text-align:justify;
    line-height:1.6;
    margin-bottom:15px;
}

.penutup{
    text-align:justify;
    line-height:1.6;
    margin-top:20px;
}

.ttd{
    width:100%;
    margin-top:45px;
}

.ttd td{
    border:none;
    font-size:12pt;
}

.document-info{
    margin-top:20px;
    margin-bottom:25px;
    line-height:1.8;
    font-size:12pt;
}

.document-info p{
    margin:3px 0;
}

.system-footer{
    margin-top:45px;
    text-align:right;
    font-size:11pt;
    line-height:1.8;
    color:#444;
}
@page{
    size:A4 landscape;
    margin:20px;
}

</style>

</head>

<body>

<!-- ================= HEADER ================= -->

<div class="header">

    <h2>PT XYZ</h2>

    <h3>SMART DISCHARGING AND RECORDING SYSTEM (SANDRA)</h3>

    <h4>LAPORAN REKAPITULASI AKTIVITAS GATE OUT KONTAINER</h4>

    <p>Dokumen ini diterbitkan secara otomatis oleh sistem</p>

</div>

<hr style="border:1px solid #000; margin-top:15px; margin-bottom:20px;">

<!-- ================= INFORMASI DOKUMEN ================= -->

<table style="border:none;width:100%;margin-bottom:25px;">

<tr>
<td width="23%"><strong>Nomor Dokumen</strong></td>
<td width="2%">:</td>
<td>GO/{{ $tanggalLaporan->format('YmdHis') }}</td>
</tr>

<tr>
<td><strong>Tanggal Laporan</strong></td>
<td>:</td>
<td>{{ $tanggalLaporan->translatedFormat('d F Y') }}</td>
</tr>

<tr>
<td><strong>Waktu Penerbitan</strong></td>
<td>:</td>
<td>{{ $tanggalLaporan->format('H:i:s') }} WIB</td>
</tr>

<tr>
<td><strong>Total Data</strong></td>
<td>:</td>
<td>{{ $data->count() }} Kontainer</td>
</tr>

</table>
<!-- ================= PENGANTAR ================= -->
<div class="pengantar">

Laporan Rekapitulasi Aktivitas Gate Out Kontainer ini diterbitkan secara otomatis oleh
<b>Smart Discharging and Recording System (SANDRA)</b>
PT XYZ sebagai hasil pencatatan aktivitas operasional Gate Out kontainer.

Seluruh informasi yang disajikan berasal dari basis data operasional yang telah
divalidasi melalui proses bisnis sistem dan digunakan sebagai media monitoring,
pelaporan, dokumentasi, serta pengarsipan aktivitas Gate Out di lingkungan PT XYZ.

</div>

<!-- ================= TABEL ================= -->

<table class="data">

<thead>

<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>No Container</th>
    <th>Kapal</th>
    <th>Voyage</th>
    <th>Agen</th>
    <th>Ukuran</th>
    <th>Tipe</th>
    <th>Status</th>
    <th>Berat</th>
    <th>POL</th>
    <th>POD</th>
    <th>No Lambung</th>
    <th>Nopol</th>
    <th>Depo</th>
</tr>

</thead>

<tbody>
@forelse($data as $i => $row)

<tr>

    <td>{{ $i + 1 }}</td>

    <td>
        {{ $row->tgl_gateout
            ? \Carbon\Carbon::parse($row->tgl_gateout)->format('d-m-Y H:i')
            : '-' }}
    </td>

    <td>{{ $row->NO_CTR }}</td>

    <td>{{ $row->NM_KAPAL }}</td>

    <td>{{ $row->VOYAGE_NO ?? '-' }}</td>

    <td>{{ $row->NM_AGEN ?? '-' }}</td>

    <td>{{ $row->SIZE_CTR ?? '-' }}</td>

    <td>{{ $row->TIPE_CTR ?? '-' }}</td>

    <td>{{ $row->STATUS_VALUE ?? '-' }}</td>

    <td>{{ $row->BERAT_CTR ?? '-' }}</td>

    <td>{{ $row->POL ?? '-' }}</td>

    <td>{{ $row->POD ?? '-' }}</td>

    <td>{{ $row->No_Lambung ?? '-' }}</td>

    <td>{{ $row->Nopol ?? '-' }}</td>

    <td>{{ $row->Depo_Tujuan ?? '-' }}</td>

</tr>

@empty

<tr>

<td colspan="15" style="text-align:center;">
Tidak terdapat data sesuai filter yang dipilih.
</td>

</tr>

@endforelse

</tbody>

</table>

<br>

<p style="text-align:right;">
<b>Total Kontainer : {{ $data->count() }} Unit</b>
</p>

<!-- ================= PENUTUP ================= -->

<div class="penutup">

Dokumen ini diterbitkan secara otomatis oleh
<b>Smart Discharging and Recording System (SANDRA)</b>
PT XYZ berdasarkan data operasional yang tersimpan pada basis data sistem.

Laporan ini digunakan sebagai dokumen pendukung kegiatan operasional,
monitoring, pelaporan, dan pengarsipan aktivitas Gate Out Kontainer.
Apabila terjadi perbedaan informasi, maka data yang tersimpan pada sistem
SANDRA menjadi sumber data utama (source of truth).

</div>
<!-- ================= TANDA TANGAN ================= -->

<hr style="margin-top:40px;">

<div style="font-size:10pt;text-align:center;color:#666;line-height:1.5;">

Dokumen ini dihasilkan secara otomatis oleh
<b>Smart Discharging and Recording System (SANDRA)</b><br>

PT XYZ

<br><br>

Dicetak pada
{{ $tanggalLaporan->translatedFormat('d F Y') }}
pukul
{{ $tanggalLaporan->format('H:i:s') }} WIB

</div>
</body>
</html>