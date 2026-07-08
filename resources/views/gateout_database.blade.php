@php
    $role = session('role');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Gate Out</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #f3f6fa;
      font-family: "Poppins", sans-serif;
    }

    .modal-content {
      border-radius: 22px !important;
      border: none;
      box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .modal-header {
      background: #0F4C81;
      color: white;
      border-top-left-radius: 22px !important;
      border-top-right-radius: 22px !important;
      padding: 20px 25px;
    }

    .modal-title {
      font-size: 20px;
      font-weight: 700;
    }

    .filter-input {
      height: 48px;
      border-radius: 12px;
      padding-left: 12px;
      font-size: 14px;
    }

    .table thead tr {
      background: #0F4C81;
      color: white;
      font-size: 14px;
    }

    .table tbody tr td {
      padding: 14px;
      font-size: 14px;
    }

    .btn-filter { 
      background: #0F4C81; 
      color: white; 
      font-weight: 600;
      border-radius: 12px;
      height: 48px;
      padding: 0 20px;
    }

    .btn-excel { 
      background: #26A541; 
      color: white; 
      font-weight: 600;
      border-radius: 12px;
      height: 48px;
      padding: 0 20px;
    }

    .btn-pdf { 
      background: #D9534F; 
      color: white; 
      font-weight: 600;
      border-radius: 12px;
      height: 48px;
      padding: 0 20px;
    }

    .modal-footer {
      border-top: none;
      padding: 18px;
    }

    .btn-close-white {
      filter: invert(1);
    }
  </style>
</head>

<body>


<!-- ========================= -->
<!-- MODAL DATA GATE OUT -->
<!-- ========================= -->
<div class="container mt-5">

<div class="modal-content mx-auto" style="max-width: 900px;">

      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-arrow-right-circle-fill me-2"></i> Data Gate Out
        </h5>
      </div>

      <div class="modal-body p-4">

        <!-- FILTER INPUT -->
        <div class="row g-3 mb-3">

          <div class="col-md-3">
            <input type="text" class="form-control filter-input" placeholder="dd/mm/yy">
          </div>

          <div class="col-md-3">
            <select class="form-control filter-input">
              <option>Semua Kapal</option>
              @foreach($gateout->unique('NM_KAPAL') as $g)
                <option>{{ $g->NM_KAPAL }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-3">
            <input type="text" class="form-control filter-input" placeholder="No. Cont, Truck, Nopol">
          </div>

          <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-filter"><i class="bi bi-funnel-fill me-1"></i> Filter</button>
            <button class="btn btn-excel"><i class="bi bi-file-excel-fill me-1"></i> Excel</button>
            <button class="btn btn-pdf"><i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF</button>
          </div>

        </div>

        <!-- TABLE -->
        <div style="max-height: 400px; overflow-y:auto;">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>No. Container</th>
              <th>Kapal</th>
              <th>Agen</th>
              <th>Truck</th>
              <th>Nopol</th>
              <th>Depo</th>
              <th>Tanggal</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($gateout as $i => $g)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $g->NO_CTR }}</td>
              <td>{{ $g->NM_KAPAL }}</td>
              <td>{{ $g->NM_AGEN }}</td>
              <td>{{ $g->No_Lambung }}</td>
              <td>{{ $g->Nopol }}</td>
              <td>{{ $g->Depo_Tujuan }}</td>
              <td>{{ $g->tgl_gateout }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary px-4 py-2 rounded-3">Tutup</button>
      </div>

</div>

</div>

</body>
</html>
