<x-app-layout>
    <x-slot name="header"><h2>DASHBOARD PEMINJAM</h2></x-slot>
    <style>table, th, td { border: 1px solid black; border-collapse: collapse; padding: 10px; width: 100%; } .card { border:1px solid #ccc; padding:10px; margin-bottom:10px; }</style>

    <div style="padding: 20px;">
        @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif

        <h3>Ajukan Peminjaman</h3>
        @foreach($alats as $alat)
            <div class="card" style="display:inline-block; width: 30%;">
                <h4>{{ $alat->nama_alat }}</h4>
                <p>Stok: {{ $alat->stok }}</p>
                <form action="{{ route('pinjam.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="alat_id" value="{{ $alat->id }}">
                    <small>Tgl Pinjam:</small><br>
                    <input type="date" name="tanggal_pinjam" required><br>
                    <small>Tgl Kembali:</small><br>
                    <input type="date" name="tanggal_kembali" required><br><br>
                    <button>PINJAM</button>
                </form>
            </div>
        @endforeach

        <hr>

        <h3>Riwayat Saya</h3>
        <table>
            <tr>
                <th>Alat</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
            @foreach($riwayats as $r)
            <tr>
                <td>{{ $r->alat->nama_alat }}</td>
                <td>{{ $r->tanggal_pinjam }} s/d {{ $r->tanggal_kembali }}</td>
                <td>
                    <b>{{ strtoupper($r->status) }}</b>
                    @if($r->status == 'kembali') <br> Tgl Balik: {{ $r->tgl_dikembalikan }} @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>