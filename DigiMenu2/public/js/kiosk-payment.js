let paymentCart = [];
let selectedPaymentMethod = null;

document.addEventListener("DOMContentLoaded", () => {
    // Ambil data keranjang dari memori browser
    const savedCart = sessionStorage.getItem('kiosk_cart');
    if (savedCart) {
        paymentCart = JSON.parse(savedCart);
    }

    // Set info header
    const orderType = sessionStorage.getItem('kiosk_order_type');
    const tableName = sessionStorage.getItem('kiosk_table_name');
    
    if (orderType === 'takeaway') {
        document.getElementById('pay-table').innerText = 'TAKEAWAY';
    } else {
        document.getElementById('pay-table').innerText = tableName || '-';
    }

    renderPaymentTable();
    updateClock();
    setInterval(updateClock, 1000);
});

function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    const payTime = document.getElementById('pay-time');
    if(payTime) payTime.innerText = timeString;
}

function renderPaymentTable() {
    const tableBody = document.getElementById('payment-cart-list');
    if (!tableBody) return;
    
    tableBody.innerHTML = '';
    let grandTotal = 0;

    paymentCart.forEach((item) => {
        const subtotal = item.price * item.qty;
        grandTotal += subtotal;

        tableBody.innerHTML += `
            <div class="table-row">
                <div class="col-item"><span>${item.name.toUpperCase()}</span></div>
                <div class="col-price">IDR ${new Intl.NumberFormat('id-ID').format(item.price)}</div>
                <div class="col-qty">${item.qty}</div>
                <div class="col-subtotal">IDR ${new Intl.NumberFormat('id-ID').format(subtotal)}</div>
            </div>
        `;
    });

    const grandTotalEl = document.getElementById('pay-grand-total');
    if(grandTotalEl) grandTotalEl.innerText = `IDR ${new Intl.NumberFormat('id-ID').format(grandTotal)}`;
}

function selectMethod(method) {
    selectedPaymentMethod = method;
    const buttons = document.querySelectorAll('.btn-method');
    buttons.forEach(btn => btn.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
}

function processCheckout() {
    // Pengecekan awal dengan Pop-up Warning
    if (paymentCart.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Keranjang Kosong',
            text: 'Tidak ada pesanan untuk diproses.',
            confirmButtonColor: '#cc8e69'
        });
        return;
    }
    if (!selectedPaymentMethod) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Pembayaran',
            text: 'Silakan pilih metode pembayaran (CASH atau QRIS)!',
            confirmButtonColor: '#cc8e69'
        });
        return;
    }

    // Hitung total ulang
    let totalAmount = paymentCart.reduce((total, item) => total + (item.price * item.qty), 0);

    const orderData = {
        order_type: sessionStorage.getItem('kiosk_order_type'),
        table_id: sessionStorage.getItem('kiosk_table_id'),
        guest_count: sessionStorage.getItem('kiosk_guest_count') || 1,
        total_amount: totalAmount,
        payment_method: selectedPaymentMethod,
        cart: paymentCart
    };

    const targetUrl = window.location.origin + '/process-checkout';
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');

    // MUNCULKAN POP-UP LOADING SEBELUM REQUEST KE SERVER
    Swal.fire({
        title: 'Memproses Pesanan...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Kirim data ke backend Laravel
    fetch(targetUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfMeta.getAttribute('content')
        },
        body: JSON.stringify(orderData)
    })
    .then(response => {
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // POP-UP SUKSES
            Swal.fire({
                icon: 'success',
                title: 'Transaksi Berhasil!',
                text: 'Pesanan Anda sedang disiapkan.',
                showConfirmButton: false,
                timer: 3000 // Otomatis tertutup setelah 3 detik
            }).then(() => {
                sessionStorage.clear(); // Bersihkan keranjang
                window.location.href = '/'; // Balik ke Home
            });
        } else {
            // POP-UP GAGAL DARI SERVER
            Swal.fire({
                icon: 'error',
                title: 'Gagal Memproses',
                text: data.message,
                confirmButtonColor: '#e74c3c'
            });
        }
    })
    .catch(error => {
        console.error('Error Checkout:', error);
        // POP-UP ERROR KONEKSI
        Swal.fire({
            icon: 'error',
            title: 'Koneksi Terputus',
            text: 'Terjadi kesalahan saat menghubungi server.',
            confirmButtonColor: '#e74c3c'
        });
    });
}