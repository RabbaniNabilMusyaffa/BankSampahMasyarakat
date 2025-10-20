// ========== SIDEBAR TOGGLE ==========
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
}

// ========== MODAL ==========
function showModal(modalId) {
    document.getElementById(modalId).classList.add('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
    // Reset form jika ada
    const form = document.querySelector(`#${modalId} form`);
    if (form) {
        form.reset();
        const totalDisplay = document.getElementById('totalDisplay');
        if (totalDisplay) {
            totalDisplay.style.display = 'none';
        }
    }
}

// Tutup modal ketika klik di luar modal
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
}

// ========== HITUNG TOTAL SETORAN ==========
function hitungTotal() {
    const kategoriSelect = document.getElementById('kategori');
    const berat = document.getElementById('berat').value;
    
    if (kategoriSelect && berat) {
        // ambil harga dari data-harga attribute
        const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];
        const hargaPerKg = selectedOption.getAttribute('data-harga');
        
        if (hargaPerKg) {
            const total = parseFloat(hargaPerKg) * parseFloat(berat);
            
            const totalInput = document.getElementById('total');
            const totalHiddenInput = document.getElementById('total_harga');
            const totalNominal = document.getElementById('totalNominal');
            const totalDisplay = document.getElementById('totalDisplay');
            
            if (totalInput) {
                totalInput.value = 'Rp ' + total.toLocaleString('id-ID');
            }
            if (totalHiddenInput) {
                totalHiddenInput.value = total;
            }
            if (totalNominal) {
                totalNominal.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
            if (totalDisplay) {
                totalDisplay.style.display = 'block';
            }
        }
    } else {
        const totalInput = document.getElementById('total');
        const totalHiddenInput = document.getElementById('total_harga');
        const totalNominal = document.getElementById('totalNominal');
        const totalDisplay = document.getElementById('totalDisplay');
        
        if (totalInput) totalInput.value = 'Rp 0';
        if (totalHiddenInput) totalHiddenInput.value = 0;
        if (totalNominal) totalNominal.textContent = 'Rp 0';
        if (totalDisplay) totalDisplay.style.display = 'none';
    }
}

// ========== SUBMIT SETORAN (untuk static page) ==========
function submitSetoran(event) {
    event.preventDefault();
    
    const pelanggan = document.getElementById('pelanggan').value;
    const kategoriSelect = document.getElementById('kategori');
    const kategori = kategoriSelect.selectedOptions[0].text;
    const berat = document.getElementById('berat').value;
    const total = document.getElementById('total').value;
    const keterangan = document.getElementById('keterangan').value;
    
    // Dapatkan waktu sekarang
    const now = new Date();
    const waktu = now.getHours() + ':' + String(now.getMinutes()).padStart(2, '0');
    
    // Tambahkan ke tabel
    const table = document.getElementById('tableSetoran');
    if (table) {
        const tbody = table.getElementsByTagName('tbody')[0];
        const newRow = tbody.insertRow(0);
        
        // Ekstrak nama kategori tanpa harga
        const namaKategori = kategori.split('(')[0].trim();
        
        newRow.innerHTML = `
            <td>${waktu}</td>
            <td>${pelanggan}</td>
            <td>${namaKategori}</td>
            <td>${berat}</td>
            <td>${total}</td>
            <td><span class="badge badge-success">Selesai</span></td>
        `;
    }
    
    // Tampilkan alert sukses
    alert(`✅ Setoran berhasil disimpan!\n\nPelanggan: ${pelanggan}\nKategori: ${kategori.split('(')[0].trim()}\nBerat: ${berat} kg\nTotal: ${total}\n\nSaldo pelanggan otomatis bertambah!`);
    
    // Tutup modal
    closeModal('setoranModal');
    
    // Reset form
    event.target.reset();
    const totalDisplay = document.getElementById('totalDisplay');
    if (totalDisplay) {
        totalDisplay.style.display = 'none';
    }
}

// ========== APPROVE PENARIKAN (untuk static page) ==========
function approvePenarikan(button, nama, jumlah) {
    if (confirm(`Setujui penarikan saldo atas nama ${nama} sebesar Rp ${jumlah.toLocaleString('id-ID')}?`)) {
        const row = button.closest('tr');
        const statusCell = row.cells[4];
        const aksiCell = row.cells[5];
        
        // Update status
        statusCell.innerHTML = '<span class="badge badge-success">Disetujui</span>';
        
        // Update aksi
        aksiCell.innerHTML = '<span style="color: #48bb78; font-weight: bold;">✓ Telah Disetujui</span>';
        
        // Tampilkan alert sukses
        alert(`✅ Penarikan disetujui!\n\nPelanggan ${nama} dapat mengambil uang tunai sebesar Rp ${jumlah.toLocaleString('id-ID')}\n\nUang dapat diambil di kasir Bank Sampah.`);
    }
}

// ========== REJECT PENARIKAN (untuk static page) ==========
function rejectPenarikan(button, nama) {
    const alasan = prompt(`Masukkan alasan penolakan penarikan atas nama ${nama}:`);
    
    if (alasan && alasan.trim() !== '') {
        const row = button.closest('tr');
        const statusCell = row.cells[4];
        const aksiCell = row.cells[5];
        
        // Update status
        statusCell.innerHTML = '<span class="badge badge-danger">Ditolak</span>';
        
        // Update aksi
        aksiCell.innerHTML = '<span style="color: #dc3545; font-weight: bold;">✗ Ditolak</span>';
        
        // Tampilkan alert
        alert(`❌ Penarikan ditolak!\n\nAlasan: ${alasan}\n\nNotifikasi akan dikirim ke pelanggan ${nama}.`);
    } else if (alasan !== null) {
        alert('⚠️ Alasan penolakan harus diisi!');
    }
}

// ========== LOGOUT ==========
function logout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        alert('👋 Terima kasih! Anda telah logout dari sistem.\n\nSampai jumpa kembali!');
        // menggunakan form POST
        // window.location.href = '/logout';
    }
}

// ========== AUTO CLOSE MODAL ON ESC ==========
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.modal.active');
        modals.forEach(modal => {
            modal.classList.remove('active');
        });
    }
});

// ========== SMOOTH SCROLL ==========
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// ========== PAGE LOAD ANIMATION ==========
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    setTimeout(function() {
        document.body.style.transition = 'opacity 0.3s';
        document.body.style.opacity = '1';
    }, 100);
});

// ========== PREVENT FORM SUBMIT ON ENTER (except in textarea) ==========
document.addEventListener('keypress', function(event) {
    if (event.key === 'Enter' && event.target.tagName !== 'TEXTAREA') {
        const form = event.target.closest('form');
        if (form && event.target.tagName !== 'BUTTON') {
            event.preventDefault();
        }
    }
});

// ========== FORMAT CURRENCY INPUT (Optional Enhancement) ==========
function formatCurrency(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    if (value) {
        value = parseInt(value).toLocaleString('id-ID');
        input.value = 'Rp ' + value;
    }
}

// ========== CONSOLE INFO ==========
console.log('🌱 Bank Sampah System - Laravel Version');
console.log('📅 Loaded at:', new Date().toLocaleString('id-ID'));
console.log('✅ All scripts loaded successfully!');