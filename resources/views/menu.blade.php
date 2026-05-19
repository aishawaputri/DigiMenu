<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiMenu - Pesan</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/kiosk-menu.css') }}">
</head>
<body>
    <div class="kiosk-wrapper">
        
        <aside class="sidebar">
            <div class="logo-area">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img" onerror="this.style.display='none'">
            </div>
            <nav class="nav-menu">
                <a href="{{ url('/') }}" class="nav-link"><i class="fa-solid fa-house"></i><span>HOME</span></a>
                <a href="#" class="nav-link active"><i class="fa-regular fa-file-lines"></i><span>MENU</span></a>
                <a href="{{ url('/payment') }}" class="nav-link"><i class="fa-regular fa-credit-card"></i><span>PAYMENT</span></a>
            </nav>
        </aside>

        <main class="menu-center">
            <header class="menu-top-bar">
                <div class="search-container">
                    <input type="text" placeholder="Cari menu...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </header>

            <div class="product-area">
                <div class="product-grid">
                    @foreach($products as $product)
                    <div class="product-card" onclick="openQuantityModal({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->image_url }}')">
                        <div class="card-img-wrapper">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body">
                            <h3 class="product-title">{{ strtoupper($product->name) }}</h3>
                            <p class="product-price">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </main>

        <aside class="cart-sidebar">
            <div class="cart-header">
                <div class="header-main">
                    <h2>ORDER #</h2>
                    <div class="user-info"><span class="user-name">NAMA</span></div>
                </div>
                <div class="header-meta">
                    <span><i class="fa-solid fa-user-group"></i> GUEST: <strong class="text-orange" id="display-guest-menu">-</strong></span>
                    <span><i class="fa-solid fa-expand"></i> TABLE: <strong class="text-orange" id="display-table-menu">-</strong></span>
                </div>
            </div>

            <div class="cart-items-container" id="cart-list">
                <p class="empty-msg">Keranjang masih kosong.</p>
            </div>

            <div class="cart-summary">
                <div class="summary-row">
                    <span>SUBTOTAL</span>
                    <span id="summary-subtotal">IDR 0</span>
                </div>
    
                <div class="total-banner">
                    <span>Total to pay</span>
                    <strong id="summary-total">IDR 0</strong>
                </div>
                <div class="coupon-wrapper">
                    <input type="text" placeholder="Apply Coupon Code here">
                    <button class="btn-coupon-go"><i class="fa-solid fa-circle-arrow-right"></i></button>
                </div>
                <button class="btn-final-checkout" onclick="goToPayment()">
                    <i class="fa-solid fa-circle-arrow-right"></i> Checkout!
                </button>
            </div>
        </aside>

    </div> <div id="qtyModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalProductName">Nama Produk</h3>
                <span class="close-btn" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p>Masukkan jumlah pesanan:</p>
                <div class="qty-input-wrapper">
                    <button type="button" class="qty-btn" onclick="adjustQty(-1)">-</button>
                    <input type="number" id="inputQty" value="1" min="1">
                    <button type="button" class="qty-btn" onclick="adjustQty(1)">+</button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeModal()">BATAL</button>
                <button class="btn-confirm" onclick="confirmAddToCart()">TAMBAHKAN</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/kiosk-menu.js') }}"></script>
</body>
</html>