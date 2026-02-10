<x-app-layout>
    <x-slot name="header"><h2>DASHBOARD ADMIN</h2></x-slot>
    <style>table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; } .box { margin: 20px; padding: 20px; border: 1px solid #ccc; }</style>

    <div style="padding: 20px;">
        <div class="box" style="background: #f0f0f0;">
            <h3>Log Aktivitas</h3>
            <div style="height: 100px; overflow-y: scroll; background: white; padding: 5px;">
                @foreach($logs as $log)
                    <small>{{ $log->created_at }} - <b>{{ $log->user->name }}</b>: {{ $log->aksi }}</small><br>
                @endforeach
            </div>
        </div>

        <div class="box">
            <h3>Kelola Kategori</h3>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <input type="text" name="nama_kategori" placeholder="Nama Kategori" required>
                <button>Tambah</button>
            </form>
            <br>
            <table width="100%">
                <tr><th>Nama</th><th>Aksi</th></tr>
                @foreach($kategoris as $k)
                <tr>
                    <td>{{ $k->nama_kategori }}</td>
                    <td>
                        <form action="{{ route('admin.kategori.destroy', $k->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="box">
            <h3>Kelola Barang/Alat</h3>
            <form action="{{ route('admin.alat.store') }}" method="POST">
                @csrf
                <input type="text" name="nama_alat" placeholder="Nama Alat" required>
                <select name="kategori_id">
                    @foreach($kategoris as $k) <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option> @endforeach
                </select>
                <input type="number" name="stok" placeholder="Stok" required>
                <button>Tambah</button>
            </form>
            <br>
            <table width="100%">
                <tr><th>Nama</th><th>Kategori</th><th>Stok</th><th>Aksi</th></tr>
                @foreach($alats as $a)
                <tr>
                    <td>{{ $a->nama_alat }}</td>
                    <td>{{ $a->kategori->nama_kategori }}</td>
                    <td>{{ $a->stok }}</td>
                    <td>
                        <form action="{{ route('admin.alat.destroy', $a->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="box">
            <h3>Kelola User</h3>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nama" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="password" placeholder="Password" required>
                <select name="role">
                    <option value="peminjam">Peminjam</option>
                    <option value="petugas">Petugas</option>
                    <option value="admin">Admin</option>
                </select>
                <button>Tambah User</button>
            </form>
            <br>
            <table width="100%">
                <tr><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr>
                @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role }}</td>
                    <td>
                        @if($u->id != Auth::id())
                        <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus?')">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>