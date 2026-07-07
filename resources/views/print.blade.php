<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print Discharging Card</title>
<style>
  @page{ margin:0; }

body{
    font-family: Arial, sans-serif;
    margin:0; padding:0;
    background:rgba(0,0,0,0.55);
}

/* CARD POPUP */
.popup-wrap{
    position:fixed;
    top:50%; left:50%;
    transform:translate(-50%,-50%);
    background:white;
    width:520px;                  /* lebih lebar agar proporsional */
    border:3px solid black;
    border-radius:6px;
    padding:35px 32px;
    box-shadow:0 0 25px rgba(0,0,0,.4);
}

/* HEADER = kiri logo, kanan judul */
.header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:28px;
}
.header img{
    width:170px;                 /* sesuai gambar */
}
.header-title{
    font-size:23px;
    text-align:right;
    font-weight:bold;
    line-height:1.3;
}
.header-title span{
    font-size:11px;
    font-weight:normal;
}

/* DATA TABLE */
table{
    width:100%;
    font-size:17px;
    line-height:1.55;
}
td.label{
    font-weight:bold;
    width:180px;
}

/* TANGGAL PRINT */
.datefooter{
    margin-top:25px;
    text-align:right;
    font-size:13px;
    font-weight:bold;
}

/* TOMBOL PRINT */
.print-btn{
    margin-top:22px;
    width:100%;
    padding:10px;
    border:none;
    background:black;
    color:white;
    font-size:16px;
    font-weight:bold;
    border-radius:6px;
    cursor:pointer;
}

.close-btn{
    position:absolute;
    top:10px; right:15px;
    font-size:22px;
    background:none;
    border:none;
    cursor:pointer;
}

/* PRINT MODE */
@media print{
    body{background:white!important;}
    .no-print{display:none!important;}
    .popup-wrap{
        box-shadow:none;
        width:100%;
        border:2px solid black;
        padding:18px;
        transform:none; position:static;
    }
}
</style>
</head>
<body>

<div class="popup-wrap">

  <button class="close-btn no-print" onclick="window.close()">×</button>

  <!-- HEADER -->
  <div class="header">
      <img src="{{ asset('images/print_hitam.png') }}">
      <div class="header-title">
         DISCHARGING CARD<br>
         <span style="font-size: 12px; font-weight: normal;">Terminal Berlian</span>
      </div>
  </div>

  <!-- DETAIL -->
  <table>
      <tr><td class="label">No. Container</td> <td>: {{ $data->NO_CTR }}</td></tr>
      <tr><td class="label">Voyage</td>       <td>: {{ $data->VOYAGE_NO }}</td></tr>
      <tr><td class="label">Kapal</td>        <td>: {{ $data->NM_KAPAL }}</td></tr>
      <tr><td class="label">Agen</td>         <td>: {{ $data->NM_AGEN }}</td></tr>
      <tr><td class="label">Detail</td>       <td>: {{ $data->SIZE_CTR }}/{{ $data->TIPE_CTR }} - {{ $data->BERAT_CTR }}</td></tr>
      <tr><td class="label">Truck / Nopol</td><td>: {{ $data->No_Lambung }}/{{ $data->Nopol }}</td></tr>
      <tr><td class="label">Depo</td>         <td>: {{ $data->Depo_Tujuan }}</td></tr>
  </table>

  <!-- TANGGAL DARI DATABASE -->
  <div class="datefooter">
      Tanggal Gateout : {{ \Carbon\Carbon::parse($data->TGL_GTI)->format('d/m/Y H:i') }}
  </div>

  <button onclick="window.print()" class="print-btn no-print">PRINT</button>

</div>

</body>
</html>
