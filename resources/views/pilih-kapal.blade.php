@extends('navbar')

@section('content')

<style>
    body{
        background:#F4F6F9;
        font-family:'Poppins', sans-serif;
    }

    .wrapper{
        width:100%;
        display:flex;
        justify-content:center;
        padding-top:90px; /* agar turun dari navbar */
    }

    .card-main{
        width:52%;
        max-width:850px;
        background:#ffffff;
        border-radius:38px;
        padding:55px 65px;
        box-shadow:0px 10px 30px rgba(0,0,0,0.06);
    }

    .title-page{
        text-align:center;
        font-size:28px;
        font-weight:800;
        color:#0069C2;
        margin-bottom:48px;
    }

    label{
        font-weight:700;
        font-size:16px;
        margin-bottom:8px;
        display:block;
        color:#2F3D4A;
    }

    select{
        width:100%;
        background:#F1F3F6;
        border:none;
        height:54px;
        font-size:15.5px;
        border-radius:12px;
        padding:0 18px;
        color:#6E6E6E;
        font-weight:500;
        appearance:none;

        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%23A1A1A1' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat:no-repeat;
        background-position:right 16px center;
    }

    .btn-next{
        width:100%;
        background:#27ADEF;
        height:52px;
        margin-top:20px;
        border-radius:10px;
        border:none;
        color:white;
        font-size:16.5px;
        font-weight:700;
        transition:.2s;
    }
    .btn-next:hover{
        background:#1a95d6;
    }
</style>

<div class="wrapper">
    <div class="card-main">

        <h2 class="title-page">Pilih Kapal dan Alat HMC</h2>

        <form action="{{ route('tally.setKapal') }}" method="POST">
            @csrf

            <label for="kapal">Pilih Kapal</label>
            <select name="kapal" id="kapal" required class="mb-4">
                <option value="">-- Pilih Kapal --</option>
                @foreach ($kapal as $k)
                    <option value="{{ $k->NM_KAPAL }}">{{ $k->NM_KAPAL }}</option>
                @endforeach
            </select>

            <label for="hmc">Pilih HMC</label>
            <select name="hmc" id="hmc" required class="mb-4">
                <option value="">-- Pilih HMC --</option>
                @foreach ($hmc as $alat)
                    <option value="{{ $alat }}">{{ $alat }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-next">Lanjut ke Tally</button>
        </form>
    </div>
</div>

@endsection
