<!DOCTYPE html>
<html>
<head>
    <title>Data Gate Out</title>
</head>
<body>

<h2>Data Gate Out</h2>

<table border="1" width="100%" cellspacing="0" cellpadding="5">

<tr>
    <th>No</th>
    <th>Container</th>
    <th>Kapal</th>
    <th>Agen</th>
    <th>Truck</th>
    <th>Nopol</th>
    <th>Depo</th>
    <th>Tanggal</th>
</tr>

@foreach($data as $i => $row)

<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $row->NO_CTR }}</td>
    <td>{{ $row->NM_KAPAL }}</td>
    <td>{{ $row->NM_AGEN }}</td>
    <td>{{ $row->No_Lambung }}</td>
    <td>{{ $row->Nopol }}</td>
    <td>{{ $row->Depo_Tujuan }}</td>
    <td>{{ $row->tgl_gateout }}</td>
</tr>

@endforeach

</table>

</body>
</html>