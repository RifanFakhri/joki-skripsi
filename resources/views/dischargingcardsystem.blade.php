@extends('navbar')

@section('content')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Discharging Card System</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      background: #f3f6fa;
      font-family: 'Poppins', sans-serif;
    }

    .top-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 6px;
      margin-bottom: 30px;
    }

    .title-big {
      font-size: 28px;
      font-weight: 700;
      color: #0F4C81;
      margin-top: 2px;
    }

    .title-small {
      font-size: 15px;
      color: #7d8996;
      margin-top: -4px;
    }

    /* CLOCK BOX FIX */
    #clock-box {
      display: flex;
      align-items: center;
      justify-content: center;
      background: white;
      border: 1px solid #d8dde4;
      border-radius: 16px;
      height: 54px;
      padding: 0 18px;
      font-size: 15px;
      font-weight: 600;
      color: #0F4C81;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      white-space: nowrap;
      min-width: 260px;
      gap: 6px;
    }

    /* CONTROL PANEL */
    .control-panel {
      display: flex;
      gap: 15px;
      margin-bottom: 25px;
      flex-wrap: wrap;
    }

    .search-box {
      flex-grow: 1;
      display: flex;
      align-items: center;
      background: white;
      border: 1px solid #d8dde4;
      padding: 0 18px;
      border-radius: 16px;
      height: 54px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      min-width: 230px;
    }

    .search-box input {
      border: none;
      width: 100%;
      margin-left: 10px;
      font-size: 15px;
      outline: none;
    }

    .select-custom {
      border-radius: 16px;
      height: 54px;
      border: 1px solid #d8dde4;
      padding-left: 12px;
      font-size: 15px;
      min-width: 140px;
    }

    .btn-refresh,
    .btn-gateout {
      height: 54px;
      border-radius: 16px;
      padding: 0 24px;
      font-size: 15px;
      font-weight: 600;
      border: none;
      min-width: 150px;
    }

    .btn-refresh { background: #0F4C81; color: white; }
    .btn-gateout { background: #E3E8EF; color: #4b5563; }

    .table-wrapper {
      background: white;
      padding: 25px;
      border-radius: 20px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      overflow-x: auto;
    }

    table {
      min-width: 1200px;
      font-size: 15px;
    }

    table td {
      padding: 16px 10px;
      font-size: 15px;
    }

    table th {
      font-size: 13px;
      text-transform: uppercase;
    }

    .btn-action {
    display: block;
    width: 100%;
    padding: 8px 10px;
    margin-bottom: 5px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 10px;
    color: white !important;
    text-align: center;
    text-decoration: none !important; 
}

.btn-edit {
    background: #32B6E7;
}

.btn-gate {
    background: #FFFFFF;
    color: #4b5563 !important;
    border: 1px solid #d8dde4;
}

.btn-print {
    background: #09B200;
}

.icon-btn {
    width: 16px;
    height: 16px;
    margin-right: 6px;
}

  </style>
</head>



<div class="container mt-3">

    {{-- ================= TOP CONTROL PANEL ================= --}}
    <div class="control-panel d-flex flex-wrap gap-3 mb-3">

        {{-- CLOCK BOX --}}
        <div id="clock-box">
            <span id="clock-date"></span> |
            <span id="clock-time"></span>
        </div>

        {{-- SEARCH --}}
        <div class="search-box">
            <input type="text" id="search" placeholder="Cari data...">
        </div>

        {{-- SIZE FILTER --}}
        <select id="size_filter" class="select-custom">
            <option value="">Semua Size</option>
            <option value="20">20</option>
            <option value="40">40</option>
        </select>

        {{-- REFRESH --}}
        <button class="btn-refresh">Refresh</button>

        <button type="button"
        class="btn-gateout d-flex align-items-center justify-content-center"
        data-bs-toggle="modal"
        data-bs-target="#gateoutModal">

    <img src="{{ asset('images/ikon_gateout.png') }}"
         class="icon-btn">

    Gate Out
</button>

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="table-wrapper">
    <table class="table table-hover" id="mainTable">
            <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Voyage</th>
                <th>Kapal</th>
                <th>Agen</th>
                <th>No. Container</th>
                <th>Ukuran</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Berat</th>
                <th>POL</th>
                <th>POD</th>
                <th>No Lambung</th>
                <th>Nopol</th>
                <th>Depo</th>
                <th>Status Gateout</th>
                <th>Aksi</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($data as $i => $row)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $row->TGL_GTI }}</td>
                    <td>{{ $row->VOYAGE_NO }}</td>
                    <td>{{ $row->NM_KAPAL }}</td>
                    <td>{{ $row->NM_AGEN }}</td>
                    <td>{{ $row->NO_CTR }}</td>
                    <td>{{ $row->SIZE_CTR }}</td>
                    <td>{{ $row->TIPE_CTR }}</td>

                    {{-- STATUS E/F --}}
                    <td>{{ $row->STATUS_VALUE }}</td>

                    <td>{{ $row->BERAT_CTR }}</td>
                    <td>{{ $row->POL }}</td>
                    <td>{{ $row->POD }}</td>
                    <td>{{ $row->No_Lambung }}</td>
                    <td>{{ $row->Nopol }}</td>
                    <td>{{ $row->Depo_Tujuan }}</td>

                    {{-- STATUS GATE OUT --}}
                    <td>
                        @if (!$row->STATUS_GATEOUT || $row->STATUS_GATEOUT == 'Belum')
                            <span class="status-belum">Belum Gate Out</span>
                        @else
                            <span class="status-selesai">Sudah Gate Out</span>
                        @endif
                    </td>

                    {{-- ACTION BUTTONS --}}
                    <td style="width:100px;">
                        <a href="{{ route('discharging.edit.form', $row->NO_CTR) }}" class="btn-action btn-edit">
                            <img src="{{ asset('images/edit.png') }}" class="icon-btn"> Edit
                        </a>

                        <form action="{{ route('discharging.gateout', $row->NO_CTR) }}" method="POST">
    @csrf

    <button type="submit" class="btn-action btn-gate">
        <img src="{{ asset('images/gate.png') }}" class="icon-btn">
        Gate
    </button>
</form>

                        <a href="{{ route('discharging.print', $row->NO_CTR) }}" class="btn-action btn-print">
                            <img src="{{ asset('images/print.png') }}" class="icon-btn"> Print
                        </a>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>



{{-- ================= CLOCK SCRIPT ================= --}}
<script>
function updateClock() {

    const now = new Date();

    const optionsDate = {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    };

    const optionsTime = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    };

    document.getElementById("clock-date").textContent =
        now.toLocaleDateString('id-ID', optionsDate);

    document.getElementById("clock-time").textContent =
        now.toLocaleTimeString('id-ID', optionsTime);
}

updateClock();

setInterval(updateClock, 1000);
</script>

<!-- ========================= -->
<!-- MODAL GATE OUT -->
<!-- ========================= -->

<div class="modal fade" id="gateoutModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content" style="border-radius:22px;">

      <div class="modal-header" style="background:#007BCE; color:white; padding:22px;">
        <h5 class="modal-title">Data Gate Out</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4">
        
        <!-- FILTER -->
        <div class="row g-3 mb-3">
          
          <div class="col-md-3">
          <input type="date"
       id="filter_date"
       class="form-control"
       style="height:48px; border-radius:12px;"
              placeholder="dd/mm/yy" style="height:48px; border-radius:12px;">
          </div>

          
          <div class="col-md-3">
            <select id="filter_kapal" class="form-control"
              style="height:48px; border-radius:12px;">
              <option value="">Semua Kapal</option>
              @foreach($gateout->unique('NM_KAPAL') as $g)
                <option>{{ $g->NM_KAPAL }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-3">
            <select id="filter_depo" class="form-control"
              style="height:48px; border-radius:12px;">
              <option value="">Semua Depo</option>
              @foreach($gateout->unique('Depo_Tujuan') as $g)
                <option>{{ $g->Depo_Tujuan }}</option>
              @endforeach
            </select>
          </div>


          <div class="col-md-3">
            <input type="text" id="filter_text" class="form-control"
              placeholder="No. Container / Truck / Nopol"
              style="height:48px; border-radius:12px;">
          </div>

          <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary w-100 fw-semibold" id="btnFilter"
              style="border-radius:12px; height:48px;">Filter</button>
          </div>

        </div>

        <!-- EXPORT & EMAIL INPUT -->
        <div class="row g-2 mb-3">

          <div class="col-md-4">
            <input type="text" id="manualEmail" class="form-control"
              placeholder="Masukkan email (opsional)"
              style="height:48px; border-radius:12px;">
          </div>

          <div class="col-md-3">
    <button class="btn btn-danger w-100 fw-semibold btn-download-pdf"
        style="border-radius:12px; height:48px;">
        Download PDF
    </button>
</div>

<div class="col-md-3">
    <button class="btn btn-warning w-100 fw-semibold btn-email-pdf"
        style="border-radius:12px; height:48px;">
        Kirim PDF
    </button>
</div>

        <!-- TABLE -->
        <div style="max-height:420px; overflow-y:auto;">
          <table class="table" style="border-collapse:separate; border-spacing:0 14px;">
          <thead>
<tr style="background:#007BCE;color:white;">
    <th>No</th>
    <th>Tanggal</th>
    <th>Voyage</th>
    <th>Kapal</th>
    <th>Agen</th>
    <th>No Container</th>
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

<tbody id="gateoutTable">

@foreach($gateout as $i => $g)

<tr>

<td>{{ $i+1 }}</td>

<td data-date="{{ \Carbon\Carbon::parse($g->tgl_gateout)->format('Y-m-d') }}">
    {{ \Carbon\Carbon::parse($g->tgl_gateout)->format('d-m-Y H:i:s') }}
</td>

<td>{{ $g->VOYAGE_NO }}</td>

<td>{{ $g->NM_KAPAL }}</td>

<td>{{ $g->NM_AGEN }}</td>

<td>{{ $g->NO_CTR }}</td>

<td>{{ $g->SIZE_CTR }}</td>

<td>{{ $g->TIPE_CTR }}</td>

<td>{{ $g->STATUS_VALUE }}</td>

<td>{{ $g->BERAT_CTR }}</td>

<td>{{ $g->POL }}</td>

<td>{{ $g->POD }}</td>

<td>{{ $g->No_Lambung }}</td>

<td>{{ $g->Nopol }}</td>

<td>{{ $g->Depo_Tujuan }}</td>

</tr>

@endforeach

</tbody>

          </table>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>

<script>


document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".btn-gate").forEach(btn => {

        btn.addEventListener("click", function () {

            btn.disabled = true;
            btn.innerHTML = "Processing...";

            btn.closest("form").submit();
        });

    });

});


  /* BUKA MODAL */
  document.querySelector('.btn-gateout')
    ?.addEventListener('click', () => {
      new bootstrap.Modal(document.getElementById('gateoutModal')).show();
    });

  const filterDate  = document.getElementById("filter_date");
  const filterKapal = document.getElementById("filter_kapal");
  const filterDepo = document.getElementById("filter_depo");
  const filterText  = document.getElementById("filter_text");
  const tableBody   = document.getElementById("gateoutTable");

  /* FILTER */
  function applyFilter(){

const dateVal  = filterDate.value.trim();
const kapalVal = filterKapal.value.toLowerCase().trim();
const depoVal  = filterDepo.value.toLowerCase().trim();
const textVal  = filterText.value.toLowerCase().trim();

const rows = tableBody.querySelectorAll("tr");

rows.forEach(row => {

    const tgl   = row.children[1].dataset.date;
    const kapal = row.children[3].innerText.toLowerCase();
    const ctr   = row.children[5].innerText.toLowerCase();
    const lamb  = row.children[12].innerText.toLowerCase();
    const npol  = row.children[13].innerText.toLowerCase();
    const depo  = row.children[14].innerText.toLowerCase();

    const match =

        (dateVal === "" || tgl === dateVal) &&
        (kapalVal === "" || kapal.includes(kapalVal)) &&
        (depoVal === "" || depo.includes(depoVal)) &&
        (
            textVal === "" ||
            ctr.includes(textVal) ||
            lamb.includes(textVal) ||
            npol.includes(textVal)
        );

    row.style.display = match ? "" : "none";

});

}

document.getElementById("btnFilter")
.addEventListener("click", function(e){

    e.preventDefault();

    applyFilter();

});

 /* ===========================
 SEARCH
=========================== */

document.getElementById("search")
.addEventListener("keyup", function () {

    let value = this.value.toLowerCase();

    document.querySelectorAll("table tbody tr")
    .forEach(row => {

        row.style.display =
            row.innerText.toLowerCase().includes(value)
            ? ""
            : "none";
    });

});

 /* ===========================
   REFRESH
=========================== */
document.querySelector(".btn-refresh")
?.addEventListener("click", () => {
    location.reload();
});

/* ===========================
   REFRESH
=========================== */

document.getElementById("size_filter")
.addEventListener("change", function(){

    let size = this.value;

    document.querySelectorAll("table tbody tr")
    .forEach(row => {

        let ukuran =
        row.children[6].innerText.trim();

        row.style.display =
            size === "" || ukuran === size
            ? ""
            : "none";
    });

});

/* ===========================
   DOWNLOAD PDF SESUAI FILTER
=========================== */
document.querySelector(".btn-download-pdf")
.addEventListener("click", () => {

    const tanggal = document.getElementById("filter_date").value;
    const kapal = document.getElementById("filter_kapal").value;
    const depo = document.getElementById("filter_depo").value;
    const text = document.getElementById("filter_text").value;

    const params = new URLSearchParams({
        tanggal: tanggal,
        kapal: kapal,
        depo: depo,
        text: text
    });

    window.location.href =
        "{{ route('export.gateout.pdf') }}?" + params.toString();
});
  


  /* =============================
     EMAIL PDF
  ============================= */
  document.querySelector(".btn-email-pdf")
?.addEventListener("click", () => {

    let email = document.getElementById("manualEmail").value;

    if(email === ""){
        alert("Masukkan email terlebih dahulu");
        return;
    }

    fetch("{{ route('gateout.email.pdf') }}", {
        method: "POST",
        headers: {
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        },
        body: JSON.stringify({
            email: email
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
    })
    .catch(() => {
        alert("Gagal mengirim PDF");
    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
