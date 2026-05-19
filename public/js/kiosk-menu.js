// --- public/js/kiosk-menu.js ---

// 1. Variabel Global (Wajib ada di paling atas, di luar fungsi)
// Variabel untuk menyimpan item keranjang
let cart = []; 
// Variabel untuk menyimpan data produk yang sedang dipilih di modal/popup
let currentProduct = null; 

// --- LOGIKA MODAL / POPUP JUMLAH ---

document.addEventListener("DOMContentLoaded", () => {
    // Cek apakah ini Takeaway atau Dine In
    const orderType = sessionStorage.getItem('kiosk_order_type');
    
    if (orderType === 'takeaway') {
        // Jika Takeaway, ubah tulisan Table menjadi Takeaway
        document.getElementById('display-table-menu').innerText = 'TAKEAWAY';
        document.getElementById('display-guest-menu').innerText = '-';
    } else {
        // Jika Dine In, ambil data meja dan guest dari Session Storage
        const savedTable = sessionStorage.getItem('kiosk_table_name');
        if (savedTable) {
            document.getElementById('display-table-menu').innerText = savedTable;
        }

        const savedGuest = sessionStorage.getItem('kiosk_guest_count');
        if (savedGuest) {
            document.getElementById('display-guest-menu').innerText = savedGuest;
        }
    }
    
    // ... (kode keranjang/cart kamu yang lain biarkan tetap ada di bawah sini)
});

// Fungsi untuk membuka modal (dipanggil dari onclick kartu produk di HTML)
function openQuantityModal(id, name, price) {
    // Simpan data produk yang diklik ke variabel global agar bisa diakses fungsi lain
    currentProduct = { id, name, price }; 

    // Set nama produk di dalam modal
    const modalNameElement = document.getElementById('modalProductName');
    if (modalNameElement) modalNameElement.innerText = name;

    // Reset jumlah input ke angka 1 setiap kali modal dibuka
    const qtyInput = document.getElementById('inputQty');
    if (qtyInput) qtyInput.value = 1;

    // Tampilkan modal dengan menambahkan class 'show'
    const modal = document.getElementById('qtyModal');
    if (modal) modal.classList.add('show');
}

// Fungsi untuk menutup modal
function closeModal() {
    const modal = document.getElementById('qtyModal');
    if (modal) modal.classList.remove('show');
    // Bersihkan data produk sementara
    currentProduct = null; 
}

// Fungsi untuk tombol +/- di dalam modal
function adjustQty(amount) {
    const qtyInput = document.getElementById('inputQty');
    if (!qtyInput) return;

    // Ambil jumlah saat ini, fallback ke 1 jika error
    let currentQty = parseInt(qtyInput.value) || 1; 
    let newQty = currentQty + amount;

    // Pastikan jumlah minimal adalah 1
    if (newQty < 1) newQty = 1; 

    qtyInput.value = newQty;
}


// --- LOGIKA TOMBOL PINK "TAMBAHKAN" (INI YANG DIPERBAIKI) ---

// Fungsi konfirmasi dari modal (dipanggil dari onclick tombol pink "TAMBAHKAN" di HTML)
function confirmAddToCart() {
    const qtyInput = document.getElementById('inputQty');
    
    // Validasi keamanan: pastikan input dan data produk tersedia
    if (!qtyInput || !currentProduct) {
        console.error("Gagal menambahkan: Input jumlah atau data produk tidak ditemukan.");
        closeModal();
        return;
    }

    const qty = parseInt(qtyInput.value);

    // Validasi jumlah harus minimal 1
    if (qty > 0) {
        // Panggil fungsi utama untuk memasukkan ke array keranjang
        addToCart(currentProduct.id, currentProduct.name, currentProduct.price, qty);
        
        // Tutup popup modal setelah sukses
        closeModal();
    } else {
        alert("Jumlah pesanan minimal harus 1.");
        qtyInput.value = 1; // Reset ke 1
    }
}


// --- LOGIKA UTAMA KERANJANG (CART) ---

// Fungsi untuk menambah/update data ke array 'cart'
function addToCart(id, name, price, qty) {
    // Cek apakah produk dengan ID yang sama sudah ada di keranjang
    let existingItem = cart.find(item => item.id === id);

    if (existingItem) {
        // Jika sudah ada, tinggal tambahkan jumlahnya (update)
        existingItem.qty += qty;
    } else {
        // Jika belum ada, masukkan sebagai item baru
        cart.push({ id, name, price, qty });
    }

    // Setelah data array 'cart' berubah, cetak ulang tampilan keranjang di sebelah kanan
    renderCart();
}

// Fungsi untuk mencetak HTML keranjang ke sidebar kanan
function renderCart() {
    const cartList = document.getElementById('cart-list');
    cartList.innerHTML = '';
    
    let subtotal = 0;

    if (cart.length === 0) {
        cartList.innerHTML = '<p class="empty-msg">Keranjang masih kosong.</p>';
    } else {
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.qty;
            subtotal += itemTotal;

            // Template Card sesuai gambar referensi
            cartList.innerHTML += `
                <div class="cart-item-card">
                    <img src="${item.image}" class="card-thumb" alt="${item.name}">
                    <div class="card-info">
                        <p class="food-name">${item.name}</p>
                        <p class="food-price">IDR ${new Intl.NumberFormat('id-ID').format(itemTotal)}</p>
                    </div>
                    <div class="card-qty">
                        <span>QUANTITY</span>
                        <strong>${item.qty}</strong>
                    </div>
                </div>
            `;
        });
    }

    // Hitung Pajak Service 10%
    const grandTotal = subtotal;

    // Update Angka di UI
    const summarySubtotal = document.getElementById('summary-subtotal');
    if(summarySubtotal) summarySubtotal.innerText = `IDR ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
    
    document.getElementById('summary-total').innerText = `IDR ${new Intl.NumberFormat('id-ID').format(grandTotal)}`;

    sessionStorage.setItem('kiosk_cart', JSON.stringify(cart));
}

// Fungsi untuk menghapus item dari keranjang berdasarkan index
function removeItem(index) {
    // Hapus 1 item dari array 'cart' sesuai index
    cart.splice(index, 1); 
    // Cetak ulang tampilan
    renderCart(); 
}

// Bonus: Klik area gelap di luar modal untuk menutup popup (biar makin pro)
window.onclick = function(event) {
    const modal = document.getElementById('qtyModal');
    if (event.target == modal) {
        closeModal();
    }
}

function goToPayment() {
    if (cart.length === 0) {
        alert("Keranjang masih kosong!");
        return;
    }
    window.location.href = '/payment';
}