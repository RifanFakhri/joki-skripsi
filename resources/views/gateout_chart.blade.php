@extends('navbar')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-md-12">

            <div class="dashboard-header">

                <div>
                    <h2 class="mb-1 fw-bold">
                        📊 Total Gate Out Per Kapal
                    </h2>

                    <p class="text-muted mb-0">
                        Monitoring aktivitas gate out container berdasarkan kapal
                    </p>
                </div>

                <div class="badge-dashboard">
                    {{ $chartData->sum('total_gateout') }}
                    Container
                </div>

            </div>

        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-4">
                    <label>Tanggal Awal</label>

                    <input
                        type="date"
                        name="start_date"
                        class="form-control"
                        value="{{ request('start_date') }}">
                </div>

                <div class="col-md-4">
                    <label>Tanggal Akhir</label>

                    <input
                        type="date"
                        name="end_date"
                        class="form-control"
                        value="{{ request('end_date') }}">
                </div>

                <div class="col-md-4 d-flex align-items-end">

                    <button class="btn btn-primary me-2">
                        Filter
                    </button>

                    <a href="{{ route('gateout.chart') }}"
                       class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>
</div>

<div class="row mb-4">

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6>Total Gate Out</h6>
                <h2>{{ $totalGateout }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6>Total Kapal</h6>
                <h2>{{ $totalKapal }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6>Rata-rata per Kapal</h6>
                <h2>{{ $rataRata }}</h2>
            </div>
        </div>
    </div>

</div>

    {{-- CARD GRAFIK --}}
    <div class="card chart-card border-0">

        <div class="card-body p-4">

            <canvas id="gateoutChart" height="90"></canvas>

        </div>

    </div>

</div>


<style>

.dashboard-header{
    background: linear-gradient(135deg,#0F4C81,#1E88E5);
    border-radius:20px;
    padding:25px;
    color:white;

    display:flex;
    justify-content:space-between;
    align-items:center;

    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

.badge-dashboard{
    background:white;
    color:#0F4C81;

    padding:12px 22px;
    border-radius:15px;

    font-weight:700;
    font-size:18px;

    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.chart-card{
    border-radius:22px;
    background:white;

    box-shadow:
        0 8px 25px rgba(0,0,0,.08);
}

.card-body{
    min-height:150px;
}

</style>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($chartData->pluck('NM_KAPAL'));
const dataValues = @json($chartData->pluck('total_gateout'));

new Chart(
    document.getElementById('gateoutChart'),
    {
        type: 'bar',

        data: {
            labels: labels,

            datasets: [{
                label: 'Total Gate Out',

                data: dataValues,

                backgroundColor: [
                    '#0F4C81',
                    '#1E88E5',
                    '#42A5F5',
                    '#64B5F6',
                    '#90CAF9',
                    '#1565C0',
                    '#2196F3'
                ],

                borderRadius: 12,
                borderSkipped: false,
                maxBarThickness: 55
            }]
        },

        options: {

            responsive:true,

            maintainAspectRatio:false,

            plugins: {

                legend:{
                    display:false
                },

                tooltip:{
                    backgroundColor:'#0F4C81',

                    titleFont:{
                        size:14
                    },

                    bodyFont:{
                        size:13
                    },

                    padding:12,

                    callbacks:{
                        label:function(context){
                            return context.raw + ' Container';
                        }
                    }
                }
            },

            scales:{

                x:{

                    ticks:{
                        color:'#444',
                        font:{
                            size:12,
                            weight:'600'
                        }
                    },

                    grid:{
                        display:false
                    }
                },

                y:{

                    beginAtZero:true,

                    ticks:{
                        stepSize:1,
                        color:'#444'
                    },

                    grid:{
                        color:'#e5e7eb'
                    }
                }
            },

            animation:{
                duration:1500
            }
        }
    }
);

</script>

@endsection