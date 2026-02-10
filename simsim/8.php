<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alat;
use App\Models\Peminjaman;

class PeminjamController extends Controller
{
    public function index() {
        $alats = Alat::where('stok', '>', 0)->get();
        $riwayats = Peminjaman::with('alat')->where('user_id', Auth::id())->latest()->get();
        return view('peminjam.dashboard', compact('alats', 'riwayats'));
    }

    public function store(Request $req) {
        Peminjaman::create([
            'user_id' => Auth::id(),
            'alat_id' => $req->alat_id,
            'tanggal_pinjam' => $req->tanggal_pinjam,
            'tanggal_kembali' => $req->tanggal_kembali,
            'status' => 'menunggu'
        ]);
        return back()->with('success', 'Berhasil Diajukan');
    }
}