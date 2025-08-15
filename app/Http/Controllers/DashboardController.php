<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Panitia;
use App\Models\Kegiatan;
use App\Models\Absensi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah data
        $totalPeserta = Peserta::count();
        $totalPanitia = Panitia::count();
        $totalKegiatan = Kegiatan::count();
        $totalAnggota = $totalPeserta + $totalPanitia;

        // Kehadiran hari ini
        $hadirHariIni = Absensi::whereDate('waktu_absen', Carbon::today())->count();
        $belumHadir = max($totalAnggota - $hadirHariIni, 0);

        // Data tambahan untuk ditampilkan
        $kegiatanTerbaru = Kegiatan::orderBy('tanggal_mulai', 'desc')
                                   ->take(5)
                                   ->get(['id', 'nama_kegiatan', 'tanggal_mulai']);

        $absensiHariIni = Absensi::whereDate('waktu_absen', Carbon::today())
                                 ->with(['user' => function($q) {
                                     $q->select('id', 'name', 'role');
                                 }])
                                 ->latest('waktu_absen')
                                 ->take(10)
                                 ->get();

        $data = [
            'totalPeserta'     => $totalPeserta,
            'totalPanitia'     => $totalPanitia,
            'totalKegiatan'    => $totalKegiatan,
            'hadirHariIni'     => $hadirHariIni,
            'belumHadir'       => $belumHadir,
            'kegiatanTerbaru'  => $kegiatanTerbaru,
            'absensiHariIni'   => $absensiHariIni
        ];

        return view('dashboard', $data);
    }
}
