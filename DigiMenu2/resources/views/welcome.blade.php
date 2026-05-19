<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiMenu - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/kiosk.css') }}">
</head>
<body>
    <div id="welcomeModal" class="welcome-modal">
    <div class="welcome-content">
        <img src="{{ asset('images/logo.png') }}" alt="DigiMenu" class="welcome-logo" onerror="this.style.display='none'">
        <h2>Welcome to DigiMenu!</h2>
        <p>Where will you be eating today?</p>
        
        <div class="order-options">
            <button class="btn-option" onclick="selectOrderType('dine_in')">
                <i class="fa-solid fa-utensils"></i>
                <span>DINE IN</span>
            </button>
            <button class="btn-option takeaway" onclick="selectOrderType('takeaway')">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>TAKEAWAY</span>
            </button>
        </div>
    </div>
</div>
    <div class="kiosk-wrapper">
        <aside class="sidebar">
            <div class="logo-area">
                <img src="{{ asset('images/logo.png') }}" alt="DigiMenu" class="logo-img" onerror="this.style.display='none'">
            </div>
            <nav class="nav-menu">
                <a href="{{ url('/') }}" class="nav-link active">
                    <i class="fa-solid fa-house"></i>
                    <span>HOME</span>
                </a>
                <a href="{{ url('/menu') }}" class="nav-link">
                    <i class="fa-regular fa-file-lines"></i>
                    <span>MENU</span>
                </a>
                <a href="{{ url('/payment') }}" class="nav-link">
                    <i class="fa-regular fa-credit-card"></i>
                    <span>PAYMENT</span>
                </a>
            </nav>
        </aside>

        <main class="main-workspace">
            <header class="top-bar">
                <div class="time-display">
                    <i class="fa-regular fa-calendar"></i>
                    <span id="live-datetime">May 13 th 2026, 10:00AM</span>
                </div>
                <button class="btn-add">
                    <i class="fa-solid fa-plus"></i> ADD TABLE
                </button>
            </header>

            <div class="content-body">
                <div class="page-title-row">
                    <h1 class="page-title">TABLE LIST</h1>
                    <div class="floor-selector">
                        <button class="floor-btn active">First Floor</button>
                        <button class="floor-btn">Second Floor</button>
                    </div>
                </div>

                <div class="table-container">
                    @forelse($tables as $table)
                        @php
                            // Cek apakah meja sedang dipakai (ada order pending)
                            $isOccupied = isset($table->orders_count) && $table->orders_count > 0;
                        @endphp

                        <div class="table-item {{ $isOccupied ? 'occupied' : '' }}" 
                             @if(!$isOccupied) onclick="selectTable('{{ $table->name }}', {{ $table->id }})" @endif>
                            
                            <div class="table-shape">
                                <div class="chair top-left"></div>
                                <div class="chair top-right"></div>
                                <div class="chair bottom-left"></div>
                                <div class="chair bottom-right"></div>
                                <div class="table-center">
                                    <span>{{ strtoupper($table->name) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: span 3; text-align: center; color: #999; padding: 50px;">
                            <p>Belum ada data meja di database.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <footer class="action-footer">
    <div class="selection-status">
        <div class="status-box">
            <i class="fa-solid fa-expand"></i> TABLE: <span id="display-table" class="highlight-text">-</span>
        </div>
        
        <div class="status-box">
            <i class="fa-solid fa-user-group"></i> GUEST:
            <div class="guest-counter">
                <button type="button" class="btn-qty" onclick="adjustGuest(-1)">-</button>
                <span id="display-guest" class="highlight-text">1</span>
                <button type="button" class="btn-qty" onclick="adjustGuest(1)">+</button>
            </div>
        </div>
    </div>
    <button class="btn-proceed" onclick="proceedToMenu()">SELECT AND CONTINUE</button>
</footer>
        </main>
    </div>

    <script src="{{ asset('js/kiosk.js') }}"></script>
</body>
</html>