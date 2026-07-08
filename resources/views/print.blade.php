@php
    $role = session('role');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Print Discharging Card</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

@page{
    margin:0;
}

body{
    margin:0;
    padding:0;
    background:rgba(0,0,0,.55);
    font-family:'Poppins',sans-serif;
}

/* =========================
   POPUP
========================= */

.popup-wrap{

    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);

    width:470px;
    max-width:95%;

    background:#fff;

    border-radius:14px;

    box-shadow:0 12px 40px rgba(0,0,0,.25);

    overflow:hidden;

}

/* =========================
HEADER
========================= */

.header{

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:22px;

    border-bottom:1px solid #ececec;

}

.logo{

    display:flex;
    align-items:center;
    gap:14px;

}

.logo img{

    width:60px;

}

.logo-text{

    font-size:20px;
    font-weight:700;
    color:#1b1b1b;

}

.logo-text span{

    display:block;

    font-size:12px;

    color:#777;

    font-weight:500;

}

.title{

    text-align:right;

}

.title h2{

    margin:0;

    font-size:20px;

    font-weight:700;

}

.title small{

    color:#777;

    font-size:12px;

}

/* =========================
BODY
========================= */

.content{

    padding:22px;

}

table{

    width:100%;
    border-collapse:collapse;

}

table td{

    padding:6px 0;

    font-size:14px;

}

.label{

    width:150px;

    color:#555;

    font-weight:600;

}

.value{

    font-weight:500;

    color:#222;

}

/* =========================
FOOTER BUTTON
========================= */

.footer{

    padding:20px;

    display:flex;

    gap:12px;

}

.print-btn{

    flex:1;

    background:#0F4C81;

    color:white;

    border:none;

    border-radius:10px;

    padding:12px;

    font-weight:600;

    cursor:pointer;

}

.print-btn:hover{

    background:#0b3b65;

}

.close-btn{

    width:50px;

    border:none;

    background:#e8e8e8;

    border-radius:10px;

    font-size:22px;

    cursor:pointer;

}

.close-btn:hover{

    background:#d9d9d9;

}

/* =========================
PRINT
========================= */

@media print{

    body{

        background:white;

    }

    .popup-wrap{

        position:static;

        transform:none;

        width:100%;

        max-width:100%;

        border-radius:0;

        box-shadow:none;

    }

    .no-print{

        display:none;

    }

}

</style>

</head>

<body>

<div class="popup-wrap">

    <div class="header">

        <div class="logo">

            <img src="{{ asset('images/fix-logo.png') }}">

            <div class="logo-text">
                SANDRA
                <span>Smart Discharging & Recording System</span>
            </div>

        </div>
        <div class="title">

    <h2>DISCHARGING CARD</h2>

    <small>
        {{ $printTime->translatedFormat('d F Y') }}<br>
        {{ $printTime->format('H:i:s') }}
    </small>

</div>

    </div>

    <div class="content">

        <table>

            <tr>
                <td class="label">No. Container</td>
                <td class="value">: {{ $data->NO_CTR }}</td>
            </tr>

            <tr>
                <td class="label">Voyage</td>
                <td class="value">: {{ $data->VOYAGE_NO }}</td>
            </tr>

            <tr>
                <td class="label">Kapal</td>
                <td class="value">: {{ $data->NM_KAPAL }}</td>
            </tr>

            <tr>
                <td class="label">Agen</td>
                <td class="value">: {{ $data->NM_AGEN }}</td>
            </tr>

            <tr>
                <td class="label">Detail</td>
                <td class="value">
                    : {{ $data->SIZE_CTR }}/{{ $data->TIPE_CTR }} - {{ $data->BERAT_CTR }}
                </td>
            </tr>

            <tr>
    <td class="label">Status</td>
    <td class="value">
        : {{ $data->STATUS_VALUE }}
    </td>
</tr>

            <tr>
                <td class="label">Truck / Nopol</td>
                <td class="value">
                    : {{ $data->No_Lambung }} / {{ $data->Nopol }}
                </td>
            </tr>

            <tr>
                <td class="label">Depo</td>
                <td class="value">
                    : {{ $data->Depo_Tujuan }}
                </td>
            </tr>

        



        </table>

    </div>

    <div class="footer no-print">

    <button class="print-btn" onclick="printCard()">
    🖨 PRINT
</button>

        <button class="close-btn" onclick="closePopup()">
            ×
        </button>

    </div>

</div>
<script>

function closePopup(){

    if(window.opener){
        window.close();
    }else{
        history.back();
    }

}

</script>

</body>
</html>