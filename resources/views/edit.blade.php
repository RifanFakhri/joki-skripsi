<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: rgba(0,0,0,0.4);
            height: 100vh;
            margin: 0;
            padding: 0;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .modal-card {
            background: white;
            width: 85%;
            max-width: 1100px;
            padding: 40px;
            border-radius: 35px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }

        .section-title {
            background: #0066c5;
            color: white;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 10px;
            text-align: center;
        }

        .input-custom {
            border-radius: 12px;
            border: 1px solid #d0d0d0;
            padding: 10px;
        }

        .btn-save {
            background: #0096ff;
            color: white;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 10px;
        }

        .btn-cancel {
            background: #ccc;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="modal-card">

    <h3 class="mb-4 d-flex align-items-center">
        <img src="https://img.icons8.com/ios-filled/50/000000/edit.png" width="28" class="me-2">
        Edit Data
    </h3>

    <form action="{{ route('discharging.edit', $data->NO_CTR) }}" method="POST">
        @csrf

        <div class="row mb-3">
    <div class="col-md-4">
        <div class="section-title">Voyage</div>
        <input type="text" name="voyage" class="form-control input-custom" 
               value="{{ $data->VOYAGE_NO }}">
    </div>

    <div class="col-md-4">
        <div class="section-title">Nama Kapal</div>
        <input type="text" name="nama_kapal" class="form-control input-custom" 
               value="{{ $data->NM_KAPAL }}">
    </div>

    <div class="col-md-4">
        <div class="section-title">Nama Agen</div>
        <input type="text" name="nama_agen" class="form-control input-custom" 
               value="{{ $data->NM_AGEN }}">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-3">
        <div class="section-title">Ukuran</div>
        <input type="text" name="ukuran" class="form-control input-custom" 
               value="{{ $data->SIZE_CTR }}">
    </div>

    <div class="col-md-3">
        <div class="section-title">Tipe</div>
        <input type="text" name="tipe" class="form-control input-custom" 
               value="{{ $data->TIPE_CTR }}">
    </div>

    <div class="col-md-3">
        <div class="section-title">Berat</div>
        <input type="text" name="berat" class="form-control input-custom" 
               value="{{ $data->BERAT_CTR }}">
    </div>

    <div class="col-md-3">
        <div class="section-title">Depo</div>
        <input type="text" name="depo" class="form-control input-custom" 
               value="{{ $data->Depo_Tujuan }}">
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="section-title">Nama Truck / No Lambung</div>
        <input type="text" name="nama_truck" class="form-control input-custom" 
               value="{{ $data->No_Lambung }}">
    </div>

    <div class="col-md-6">
        <div class="section-title">No. Polisi</div>
        <input type="text" name="no_polisi" class="form-control input-custom" 
               value="{{ $data->Nopol }}">
    </div>
</div>


        <div class="d-flex justify-content-end">
            <a href="{{ url('/dischargingcardsystem') }}" class="btn btn-cancel me-3">Batalkan</a>
            <button class="btn btn-save">Simpan</button>
        </div>
    </form>

</div>

</body>
</html>
