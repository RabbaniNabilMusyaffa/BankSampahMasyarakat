<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <div id="setoranModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>📝 Input Setoran Sampah</h3>
                <button class="close-modal" onclick="closeModal('setoranModal')">×</button>
            </div>
            <form onsubmit="submitSetoran(event)">
                <div class="form-group">
                    <label>Pilih Pelanggan *</label>
                    <select id="pelanggan" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <option value="Siti Aminah">Siti Aminah</option>
                        <option value="Ahmad Ridwan">Ahmad Ridwan</option>
                        <option value="Dewi Lestari">Dewi Lestari</option>
                        <option value="Rina Wati">Rina Wati</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kategori Sampah *</label>
                    <select id="kategori" required onchange="hitungTotal()">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="2000">Plastik (Rp 2,000/kg)</option>
                        <option value="1500">Kertas (Rp 1,500/kg)</option>
                        <option value="5000">Logam (Rp 5,000/kg)</option>
                        <option value="1000">Kaca (Rp 1,000/kg)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Berat (Kg) *</label>
                    <input type="number" id="berat" step="0.1" placeholder="0.0" required oninput="hitungTotal()">
                </div>
                <div class="form-group">
                    <label>Total Harga</label>
                    <input type="text" id="total" readonly placeholder="Rp 0">
                </div>
                <div class="total-display" id="totalDisplay" style="display: none;">
                    <h3>Total: <span id="totalNominal">Rp 0</span></h3>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea id="keterangan" rows="2" placeholder="Keterangan tambahan (opsional)"></textarea>
                </div>
                <button type="submit" class="btn btn-success">✓ Simpan Setoran</button>
                <button type="button" class="btn btn-danger" onclick="closeModal('setoranModal')">✗ Batal</button>
            </form>
        </div>
    </div>
</body>
</html>