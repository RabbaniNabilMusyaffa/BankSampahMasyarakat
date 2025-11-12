{{-- Ini adalah isi file: resources/views/page_admin/_laporan_export.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Berat (Kg)</th>
                <th>Nominal</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ( $data_laporan as $laporan)
            <tr>
                <td>{{ $laporan->created_at->format('Y-m-d H:i') }}</td>
                @if ($laporan instanceof \App\Models\TransaksiTarik)
                    <td>{{ $laporan->pelanggan->name ?? 'N/A' }}</td>
                    <td>Penarikan</td>
                    <td>{{ $laporan->status }}</td>
                    <td>-</td>
                    <td>-{{ $laporan->jumlah }}</td>
                    <td>{{ $laporan->validator->name ?? 'N/A' }}</td>
                @else
                    <td>{{ $laporan->user->name ?? 'N/A' }}</td>
                    <td>{{ $laporan->catatan }}</td>
                    <td>{{ $laporan->detailSetor->first()?->kategoriSampah?->nama_kategori ?? 'N/A' }}</td>
                    <td>{{ $laporan->total_berat }}</td>
                    <td>+{{ $laporan->total_harga }}</td>
                    <td>{{ $laporan->petugas->name ?? 'N/A' }}</td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>