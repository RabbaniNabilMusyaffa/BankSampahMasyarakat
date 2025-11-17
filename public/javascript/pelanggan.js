document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const openBtn = document.getElementById('openSidebar');
    const closeBtn = document.getElementById('closeSidebar');


    const desktopToggleButton = document.getElementById('desktopToggle');

    if (desktopToggleButton) {
        desktopToggleButton.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }


    // Open sidebar mobile
    if (openBtn) {
        openBtn.addEventListener('click', function() {
            sidebar.classList.add('mobile-open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    // Fungsi untuk menutup sidebar
    function closeSidebar() {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close sidebar dari tombol close
    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
    }

    // Close overlay click
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Close sidebar escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
            closeSidebar();
        }
    });

    const navItems = document.querySelectorAll('.nav-item');
    const currentPath = window.location.pathname;

    navItems.forEach(item => {
        const itemPath = new URL(item.href).pathname;
        if (itemPath === currentPath) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });

    if (currentPath === '/') {
        document.querySelector('a[href*="home"]').classList.add('active');
    }


    // helper
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const tableRows = document.querySelectorAll('.data-table tbody tr');

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // === Filter Functionality ===
    const filterSelect = document.querySelector('.filter-select');
    if (filterSelect) {
        filterSelect.addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const tableRows = document.querySelectorAll('.data-table tbody tr');

            tableRows.forEach(row => {
                if (filterValue === 'Semua Status') {
                    row.style.display = '';
                } else {
                    const statusCell = row.querySelector('.badge');
                    if (statusCell && statusCell.textContent === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    }

    // Detail Button Click Handler
    const detailButtons = document.querySelectorAll('.btn-detail');
    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const data = {
                tanggal: row.cells[0].textContent,
                jenis: row.cells[1].textContent.trim(),
                berat: row.cells[2].textContent,
                nilai: row.cells[3].textContent,
                status: row.cells[4].textContent.trim()
            };

            // Show detail modal (you can customize this)
            showDetailModal(data);
        });
    });

    // Withdrawal Form Validation
    // const withdrawalForm = document.querySelector('.withdrawal-form');
    // if (withdrawalForm) {
    //     withdrawalForm.addEventListener('submit', function(e) {
    //         e.preventDefault();

    //         const amount = this.querySelector('input[type="number"]').value;
    //         const method = this.querySelector('select').value;
    //         const account = this.querySelectorAll('input[type="text"]')[0].value;

    //         // Validation
    //         if (!amount || amount < 50000) {
    //             showNotification('Jumlah minimum penarikan adalah Rp 50.000', 'error');
    //             return;
    //         }

    //         if (!account) {
    //             showNotification('Mohon isi nomor rekening/e-wallet', 'error');
    //             return;
    //         }

    //         // Show success message
    //         showNotification('Pengajuan penarikan berhasil! Menunggu verifikasi admin.', 'success');
    //         this.reset();
    //     });
    // }

    // Settings Form Handler
    // const settingsForm = document.querySelector('.settings-form');
    // if (settingsForm) {
    //     settingsForm.addEventListener('submit', function(e) {
    //         e.preventDefault();
    //         showNotification('Data profile berhasil diperbarui!', 'success');
    //     });
    // }

    // Toggle Switch Handler
    const toggleInputs = document.querySelectorAll('.toggle-input');
    toggleInputs.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const label = this.closest('.settings-toggle').querySelector('.settings-item-title');
            const status = this.checked ? 'diaktifkan' : 'dinonaktifkan';
            showNotification(`${label.textContent} ${status}`, 'info');
        });
    });

    // Animation on Scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    entry.target.style.transition = 'all 0.5s ease-out';
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);

                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe cards
    const cards = document.querySelectorAll('.stat-card, .transaction-card, .settings-card');
    cards.forEach(card => observer.observe(card));

    // Number Formatting for Currency
    const currencyElements = document.querySelectorAll('.stat-value, .balance-amount, .transaction-amount p, .table-amount');
    currencyElements.forEach(element => {
        const text = element.textContent;
        const numbers = text.match(/\d+/g);
        if (numbers) {
            numbers.forEach(num => {
                const formatted = parseInt(num).toLocaleString('id-ID');
                element.innerHTML = element.innerHTML.replace(num, formatted);
            });
        }
    });

    // Real-time Date Display
    updateDateTime();
    setInterval(updateDateTime, 60000);

    function updateDateTime() {
        const dateElement = document.querySelector('.header-date span');
        if (dateElement) {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            dateElement.textContent = now.toLocaleDateString('id-ID', options);
        }
    }

    // Smooth Scroll for Internal Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Helper

// Show Detail Modal
function showDetailModal(data) {
    const modal = `
        <div class="modal-overlay" onclick="closeModal()">
            <div class="modal-content" onclick="event.stopPropagation()">
                <div class="modal-header">
                    <h3>Detail Setoran</h3>
                    <button onclick="closeModal()" class="modal-close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="detail-item">
                        <span class="detail-label">Tanggal:</span>
                        <span class="detail-value">${data.tanggal}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Jenis Sampah:</span>
                        <span class="detail-value">${data.jenis}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Berat:</span>
                        <span class="detail-value">${data.berat} kg</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Nilai:</span>
                        <span class="detail-value">${data.nilai}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value">${data.status}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModal()" class="btn-secondary">Tutup</button>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modal);

    // Add modal styles
    const style = document.createElement('style');
    style.textContent = `
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.2s;
        }
        .modal-content {
            background: white;
            border-radius: 1rem;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.3s;
        }
        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
        }
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #64748b;
            cursor: pointer;
            line-height: 1;
        }
        .modal-body {
            padding: 1.5rem;
        }
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .detail-label {
            font-weight: 500;
            color: #64748b;
        }
        .detail-value {
            font-weight: 600;
            color: #0f172a;
        }
        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #f1f5f9;
            text-align: right;
        }
        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);
}

// Close Modal
function closeModal() {
    const modal = document.querySelector('.modal-overlay');
    if (modal) {
        modal.style.animation = 'fadeOut 0.2s';
        setTimeout(() => modal.remove(), 200);
    }
}

// Show Notification
function showNotification(message, type = 'info') {
    const colors = {
        success: { bg: '#d1fae5', text: '#059669', icon: '✓' },
        error: { bg: '#fee2e2', text: '#dc2626', icon: '✕' },
        info: { bg: '#dbeafe', text: '#2563eb', icon: 'ℹ' }
    };

    const color = colors[type] || colors.info;

    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 2rem;
        right: 2rem;
        background: ${color.bg};
        color: ${color.text};
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        z-index: 10000;
        animation: slideInRight 0.3s ease-out;
        max-width: 400px;
    `;

    notification.innerHTML = `
        <span style="font-size: 1.25rem;">${color.icon}</span>
        <span>${message}</span>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);

    // Add animation styles
    if (!document.getElementById('notification-animations')) {
        const style = document.createElement('style');
        style.id = 'notification-animations';
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }
}

// Chart Data Preparation
function prepareChartData() {
    const setoranData = [
        { month: 'Jan', value: 45 },
        { month: 'Feb', value: 52 },
        { month: 'Mar', value: 48 },
        { month: 'Apr', value: 61 },
        { month: 'Mei', value: 55 },
        { month: 'Jun', value: 67 },
        { month: 'Jul', value: 72 },
        { month: 'Agu', value: 68 },
        { month: 'Sep', value: 75 },
        { month: 'Okt', value: 82 }
    ];

    return setoranData;
}

// Export Data Function
function exportToCSV() {
    const table = document.querySelector('.data-table');
    if (!table) return;

    let csv = [];
    const rows = table.querySelectorAll('tr');

    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const rowData = [];

        cols.forEach((col, index) => {
            
            if (index < cols.length - 1) {
                rowData.push(col.textContent.trim());
            }
        });

        csv.push(rowData.join(','));
    });

    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'riwayat_setoran_' + new Date().toISOString().split('T')[0] + '.csv';
    a.click();
    window.URL.revokeObjectURL(url);

    showNotification('Data berhasil diexport!', 'success');
}

//Print Function
function printPage() {
    window.print();
}

// Local Storage Functions
// Save user preferences
function savePreference(key, value) {
    try {
        const preferences = JSON.parse(localStorage.getItem('bankSampahPrefs') || '{}');
        preferences[key] = value;
        localStorage.setItem('bankSampahPrefs', JSON.stringify(preferences));
    } catch (e) {
        console.log('LocalStorage not available');
    }
}

// Get user preference
function getPreference(key, defaultValue = null) {
    try {
        const preferences = JSON.parse(localStorage.getItem('bankSampahPrefs') || '{}');
        return preferences[key] !== undefined ? preferences[key] : defaultValue;
    } catch (e) {
        return defaultValue;
    }
}

// Format Number to Indonesian Currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

// Format Date to Indonesian
function formatDate(date) {
    return new Date(date).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}

// Validate Email
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// validasi nomor
function validatePhone(phone) {
    const re = /^(\+62|62|0)[0-9]{9,12}$/;
    return re.test(phone.replace(/[\s-]/g, ''));
}

// Debounce Function for Search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Copy to Clipboard
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Disalin ke clipboard!', 'success');
        });
    } else {

        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        showNotification('Disalin ke clipboard!', 'success');
    }
}

//Loading Spinner
function showLoading() {
    const loader = document.createElement('div');
    loader.id = 'loader';
    loader.style.cssText = `
        position: fixed;
        inset: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    `;
    loader.innerHTML = `
        <div style="
            width: 50px;
            height: 50px;
            border: 4px solid #e2e8f0;
            border-top-color: #059669;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        "></div>
    `;

    if (!document.getElementById('spin-animation')) {
        const style = document.createElement('style');
        style.id = 'spin-animation';
        style.textContent = `
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(loader);
}

function hideLoading() {
    const loader = document.getElementById('loader');
    if (loader) {
        loader.remove();
    }
}

// Confirm Dialog
function confirmDialog(message, onConfirm, onCancel) {
    const dialog = document.createElement('div');
    dialog.style.cssText = `
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    `;

    dialog.innerHTML = `
        <div style="
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        ">
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
                Konfirmasi
            </h3>
            <p style="color: #64748b; margin-bottom: 1.5rem;">${message}</p>
            <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button id="cancelBtn" style="
                    padding: 0.625rem 1.25rem;
                    background: #f1f5f9;
                    color: #475569;
                    border: none;
                    border-radius: 0.5rem;
                    font-weight: 500;
                    cursor: pointer;
                ">Batal</button>
                <button id="confirmBtn" style="
                    padding: 0.625rem 1.25rem;
                    background: #059669;
                    color: white;
                    border: none;
                    border-radius: 0.5rem;
                    font-weight: 500;
                    cursor: pointer;
                ">Ya, Lanjutkan</button>
            </div>
        </div>
    `;

    document.body.appendChild(dialog);

    document.getElementById('confirmBtn').addEventListener('click', () => {
        dialog.remove();
        if (onConfirm) onConfirm();
    });

    document.getElementById('cancelBtn').addEventListener('click', () => {
        dialog.remove();
        if (onCancel) onCancel();
    });
}

// Initialize Tooltips
function initTooltips() {
    const elements = document.querySelectorAll('[data-tooltip]');

    elements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const text = this.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = text;
            tooltip.style.cssText = `
                position: absolute;
                background: #1e293b;
                color: white;
                padding: 0.5rem 0.75rem;
                border-radius: 0.375rem;
                font-size: 0.813rem;
                white-space: nowrap;
                z-index: 10000;
                pointer-events: none;
            `;

            document.body.appendChild(tooltip);

            const rect = this.getBoundingClientRect();
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
            tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';

            this.tooltipElement = tooltip;
        });

        element.addEventListener('mouseleave', function() {
            if (this.tooltipElement) {
                this.tooltipElement.remove();
                this.tooltipElement = null;
            }
        });
    });
}

// Auto-save Form Data
function enableAutoSave(formSelector) {
    const form = document.querySelector(formSelector);
    if (!form) return;

    const inputs = form.querySelectorAll('input, textarea, select');

    inputs.forEach(input => {
        const savedValue = getPreference(`form_${input.name}`);
        if (savedValue && input.type !== 'password') {
            input.value = savedValue;
        }

        input.addEventListener('change', debounce(function() {
            if (this.type !== 'password') {
                savePreference(`form_${this.name}`, this.value);
            }
        }, 500));
    });
}

// Initialize all tooltips on page load
window.addEventListener('load', () => {
    initTooltips();
});

// Handle Network Status
window.addEventListener('online', () => {
    showNotification('Koneksi internet tersambung kembali', 'success');
});

window.addEventListener('offline', () => {
    showNotification('Tidak ada koneksi internet', 'error');
});

// Handle Form Submit with Loading
document.addEventListener('submit', function(e) {
    if (e.target.matches('form')) {
        const submitBtn = e.target.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg style="width: 1.25rem; height: 1.25rem; animation: spin 0.8s linear infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="4" stroke="currentColor" stroke-opacity="0.25"/>
                    <path d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"/>
                </svg>
                Memproses...
            `;

            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Simpan';
            }, 3000);
        }
    }
});

console.log('🌿 Bank Sampah EcoBank - System Ready!');
console.log('Version: 1.0.0');
console.log('Developed with for a greener future');
