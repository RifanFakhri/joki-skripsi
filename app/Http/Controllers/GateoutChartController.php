<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GateoutChartController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('dc_gateout');

        // FILTER TANGGAL
        if ($request->filled('start_date')) {
            $query->whereDate(
                'tgl_gateout',
                '>=',
                $request->start_date
            );
        }

        if ($request->filled('end_date')) {
            $query->whereDate(
                'tgl_gateout',
                '<=',
                $request->end_date
            );
        }

        // DATA CHART
        $chartData = $query
            ->select(
                'NM_KAPAL',
                DB::raw('COUNT(*) as total_gateout')
            )
            ->groupBy('NM_KAPAL')
            ->orderByDesc('total_gateout')
            ->get();

        // CARD STATISTIK
        $totalGateout = DB::table('dc_gateout')
            ->when($request->start_date, function ($q) use ($request) {
                $q->whereDate('tgl_gateout', '>=', $request->start_date);
            })
            ->when($request->end_date, function ($q) use ($request) {
                $q->whereDate('tgl_gateout', '<=', $request->end_date);
            })
            ->count();

        $totalKapal = $chartData->count();

        $rataRata = $totalKapal > 0
            ? round($totalGateout / $totalKapal, 2)
            : 0;

        return view('gateout_chart', compact(
            'chartData',
            'totalGateout',
            'totalKapal',
            'rataRata'
        ));
    }
}