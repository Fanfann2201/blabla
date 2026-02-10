<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Alat;

class PetugasController extends Controller
{
    public function index() {
        $peminjamans = Peminjaman::with(['user', 'alat'])->latest()->get();
        return view('petugas.dashboard', compact('peminjamans'));
    }

    public function approve($id) {
        $pinjam = Peminjaman::findOrFail($id);
        $alat = Alat::findOrFail($pinjam->alat_id);

        if ($alat->stok > 0) {
            $pinjam->update(['status' => 'disetujui']);
            $alat->decrement('stok'); // Stok berkurang
            return back()->with('success', 'Disetujui');
        }
        return back()->with('error', 'Stok Habis!');
    }

    public function reject($id) {
        Peminjaman::where('id', $id)->update(['status' => 'ditolak']);
        return back()->with('success', 'Ditolak');
    }

    public function return($id) {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->update(['status' => 'kembali', 'tgl_dikembalikan' => now()]);
        
        Alat::where('id', $pinjam->alat_id)->increment('stok'); // Stok balik
        return back()->with('success', 'Barang Kembali');
    }
}