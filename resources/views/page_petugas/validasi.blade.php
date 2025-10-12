<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
       <div id="penarikan" class="section">
                <div class="content-box">
                    <h2>💰 Validasi Penarikan Saldo</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12/10/2025</td>
                                <td>Siti Aminah</td>
                                <td>Rp 50,000</td>
                                <td>Untuk keperluan rumah</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <button class="btn btn-success" onclick="approvePenarikan(this, 'Siti Aminah', 50000)">✓ Setujui</button>
                                    <button class="btn btn-danger" onclick="rejectPenarikan(this, 'Siti Aminah')">✗ Tolak</button>
                                </td>
                            </tr>
                            <tr>
                                <td>12/10/2025</td>
                                <td>Ahmad Ridwan</td>
                                <td>Rp 75,000</td>
                                <td>Bayar sekolah anak</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <button class="btn btn-success" onclick="approvePenarikan(this, 'Ahmad Ridwan', 75000)">✓ Setujui</button>
                                    <button class="btn btn-danger" onclick="rejectPenarikan(this, 'Ahmad Ridwan')">✗ Tolak</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="content-box">
                    <h2>✅ Riwayat Validasi</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Divalidasi Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>10/10/2025</td>
                                <td>Dewi Lestari</td>
                                <td>Rp 100,000</td>
                                <td><span class="badge badge-success">Disetujui</span></td>
                                <td>Budi Santoso</td>
                            </tr>
                            <tr>
                                <td>09/10/2025</td>
                                <td>Rina Wati</td>
                                <td>Rp 30,000</td>
                                <td><span class="badge badge-danger">Ditolak</span></td>
                                <td>Budi Santoso</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
</body>
</html>