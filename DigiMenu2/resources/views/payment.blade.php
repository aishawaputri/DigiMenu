<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiMenu - Payment Confirmation</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/kiosk-payment.css') }}">
</head>
<body>
    <div class="kiosk-wrapper">
        <aside class="sidebar">
            <div class="logo-area">
                <img src="{{ asset('images/logo.png') }}" alt="DigiMenu" class="logo-img" onerror="this.style.display='none'">
            </div>
            <nav class="nav-menu">
                <a href="{{ url('/') }}" class="nav-link"><i class="fa-solid fa-house"></i><span>HOME</span></a>
                <a href="{{ url('/menu') }}" class="nav-link"><i class="fa-regular fa-file-lines"></i><span>MENU</span></a>
                <a href="#" class="nav-link active"><i class="fa-regular fa-credit-card"></i><span>PAYMENT</span></a>
            </nav>
        </aside>

        <main class="main-workspace">
            <header class="top-bar">
                <div class="search-box-dummy">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search product or any order.." disabled>
                </div>
                <div class="top-actions">
                    <span id="live-datetime" class="datetime-display"></span>
                    <button class="btn-add-table"><i class="fa-solid fa-plus"></i> ADD TABLE</button>
                </div>
            </header>

            <div class="payment-content">
                <div class="order-header-row">
                    <h2>ORDER: <span id="pay-order-name" class="text-orange">GUEST</span></h2>
                    <div class="order-meta">
                        <span><i class="fa-solid fa-expand"></i> TABLE: <strong id="pay-table" class="text-orange">-</strong></span>
                        <span><i class="fa-regular fa-clock"></i> TIME: <strong id="pay-time" class="text-orange">-</strong></span>
                    </div>
                </div>

                <div class="order-table">
                    <div class="table-header">
                        <div class="col-item">ITEM</div>
                        <div class="col-price">PRICE</div>
                        <div class="col-qty">QTY</div>
                        <div class="col-subtotal">SUBTOTAL</div>
                    </div>
                    
                    <div class="table-body" id="payment-cart-list">
                        </div>
                </div>

                <div class="payment-action-area">
                    <div class="total-bar-large">
                        <span>Total to Pay:</span>
                        <strong id="pay-grand-total">IDR 0</strong>
                    </div>

                    <div class="payment-methods">
                        <button class="btn-method" onclick="selectMethod('CASH')">
                            <i class="fa-solid fa-money-bill-wave"></i>
                            <span>CASH</span>
                        </button>
                        <button class="btn-method" onclick="selectMethod('QRIS')">
                            <i class="fa-solid fa-qrcode"></i>
                            <span>QRIS</span>
                        </button>
                    </div>

                    <button class="btn-process-checkout" onclick="processCheckout()">
                        <i class="fa-solid fa-circle-arrow-right"></i> CHECKOUT!
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/kiosk-payment.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="{{ asset('js/kiosk-payment.js') }}"></script>
</body>
</html>
</body>
</html>