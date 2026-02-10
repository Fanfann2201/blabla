<x-app-layout>
    <x-slot name="header"><h2>DASHBOARD PETUGAS</h2></x-slot>
    <style>table, th, td { border: 1px solid black; border-collapse: collapse; padding: 10px; width: 100%; }</style>

    <div style="padding: 20px;">
        @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif
        @if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

        <h3>Daftar Permintaan Peminjaman</h3>
        <table>
            <thead>
                <tr style="background: #ddd;">
                    <th>Peminjam</th>
                    <th>Alat</th>
                    <th>Tgl Pinjam - Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamans as $p)
                <tr>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->alat->nama_alat }}</td>
                    <td>{{ $p->tanggal_pinjam }} s/d {{ $p->tanggal_kembali }}</td>
                    <td>
                        {{ ucfirst($p->status) }} 
                        @if($p->status == 'kembali') <br><small>(Dikembalikan: {{ $p->tgl_dikembalikan }})</small> @endif
                    </td>
                    <td>
                        @if($p->status == 'menunggu')
                            <form action="{{ route('petugas.approve', $p->id) }}" method="POST" style="display:inline">
                                @csrf @method('PATCH')
                                <button style="color:green">TERIMA</button>
                            </form>
                            <form action="{{ route('petugas.reject', $p->id) }}" method="POST" style="display:inline">
                                @csrf @method('PATCH')
                                <button style="color:red">TOLAK</button>
                            </form>
                        @elseif($p->status == 'disetujui')
                            <form action="{{ route('petugas.return', $p->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button style="color:blue">SELESAI / KEMBALI</button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>