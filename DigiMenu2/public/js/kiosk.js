// --- public/js/kiosk.js ---

// 1. Variabel Global
let guestCount = 1;
let selectedTableId = null;
let selectedTableName = null;

// 2. Fungsi Memilih Tipe Order (Muncul Paling Pertama)
function selectOrderType(type) {
    // Simpan pilihan (dine_in / takeaway) ke memory browser
    sessionStorage.setItem('kiosk_order_type', type);

    if (type === 'dine_in') {
        // JIKA DINE IN: Sembunyikan layar welcome agar user bisa pilih meja
        document.getElementById('welcomeModal').classList.add('hidden');
    } 
    else if (type === 'takeaway') {
        // JIKA TAKEAWAY: Bersihkan data meja lama (kalau ada) dan langsung ke Menu
        sessionStorage.removeItem('kiosk_table_id');
        sessionStorage.removeItem('kiosk_table_name');
        sessionStorage.setItem('kiosk_guest_count', 1); // Default 1 orang
        
        // Pindah langsung ke halaman menu
        window.location.href = '/menu?type=takeaway';
    }
}

// 3. Fungsi Tambah/Kurang Jumlah Tamu (Guest)
function adjustGuest(amount) {
    guestCount += amount;

    // Batasi minimal 1 tamu
    if (guestCount < 1) guestCount = 1;

    // Update tampilan angka di layar pojok kiri bawah
    const displayGuest = document.getElementById('display-guest');
    if (displayGuest) {
        displayGuest.innerText = guestCount;
    }
}

// 4. Fungsi Memilih Meja (Klik Gambar Meja)
function selectTable(tableName, tableId) {
    // Hapus efek "terpilih" dari semua meja terlebih dahulu
    const allTableItems = document.querySelectorAll('.table-item');
    allTableItems.forEach(item => item.classList.remove('selected'));

    // Tambahkan efek "terpilih" ke meja yang baru saja diklik
    event.currentTarget.classList.add('selected');

    // Update teks UI di pojok kiri bawah
    const displayTable = document.getElementById('display-table');
    if (displayTable) {
        displayTable.innerText = tableName;
    }

    // Simpan data ke variabel global
    selectedTableId = tableId;
    selectedTableName = tableName;
}

// 5. Fungsi Lanjut ke Menu (Tombol "SELECT AND CONTINUE")
function proceedToMenu() {
    // Cegah pindah halaman jika belum pilih meja (khusus Dine In)
    if (!selectedTableId) {
        alert("Silakan pilih meja terlebih dahulu!");
        return;
    }
    
    // Simpan data meja dan tamu ke memory browser
    sessionStorage.setItem('kiosk_table_id', selectedTableId);
    sessionStorage.setItem('kiosk_table_name', selectedTableName);
    sessionStorage.setItem('kiosk_guest_count', guestCount);
    
    // Pindah ke halaman menu dengan membawa ID meja
    window.location.href = '/menu?table=' + selectedTableId;
}