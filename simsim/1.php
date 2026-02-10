<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Log;

class AdminController extends Controller
{
    // Helper untuk catat log otomatis
    private function catatLog($pesan) {
        Log::create(['user_id' => Auth::id(), 'aksi' => $pesan]);
    }

    public function index() {
        // Ambil semua data untuk ditampilkan di satu dashboard
        $users = User::all();
        $kategoris = Kategori::all();
        $alats = Alat::with('kategori')->get();
        $logs = Log::with('user')->latest()->get(); // Fitur Log Aktivitas

        return view('admin.dashboard', compact('users', 'kategoris', 'alats', 'logs'));
    }

    // --- CRUD KATEGORI ---
    public function storeKategori(Request $req) {
        Kategori::create($req->all());
        $this->catatLog("Menambah Kategori: " . $req->nama_kategori);
        return back()->with('success', 'Kategori Ditambah');
    }
    public function destroyKategori($id) {
        Kategori::destroy($id);
        $this->catatLog("Menghapus Kategori ID: " . $id);
        return back()->with('success', 'Kategori Dihapus');
    }

    // --- CRUD ALAT ---
    public function storeAlat(Request $req) {
        Alat::create($req->all());
        $this->catatLog("Menambah Alat: " . $req->nama_alat);
        return back()->with('success', 'Alat Ditambah');
    }
    public function destroyAlat($id) {
        Alat::destroy($id);
        $this->catatLog("Menghapus Alat ID: " . $id);
        return back()->with('success', 'Alat Dihapus');
    }

    // --- CRUD USER ---
    public function storeUser(Request $req) {
        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password),
            'role' => $req->role
        ]);
        $this->catatLog("Menambah User: " . $req->name);
        return back()->with('success', 'User Ditambah');
    }
    public function destroyUser($id) {
        User::destroy($id);
        $this->catatLog("Menghapus User ID: " . $id);
        return back()->with('success', 'User Dihapus');
    }
}