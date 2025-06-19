<!-- resources/views/layouts/driver.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'لوحة السائق')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        /* ... [نفس CSS الموجود في الكود السابق] ... */
    </style>
    @stack('styles')
</head>
<body>
<header>
    <div class="menu-icon" onclick="toggleSidebar()">☰</div>
    <div id="sidebar" class="sidebar">
        <a href="/contact">التواصل مع الدعم</a>
        <div class="profile-image">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMPiZw9s7cz-zlkqLs7mv1p_4GGKFDmMmUDpOD0z2Ak5L8JHQvgv6rlwYLCq_v_ROJ1e4&usqp=CAU" alt="صورة المستخدم">
            <p class="username">اسم المستخدم</p>
        </div>
        <a href="/ProfilePage">الملف الشخصي</a>
        <a href="/driver/info">المحفظه</a>
        <a href="/orders">طلباتي</a>
        <a href="/userpage">طلب جديد</a>
        <br>
        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>تسجيل الخروج</span>
            </button>
        </form>
    </div>
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>
    <nav>
        <div style="display: flex; align-items: center; gap: 25px; font-family: 'Tajawal', sans-serif; background: #f5f5f7; padding: 12px 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); color: #4A4A4A; max-width: 600px;">
            @if(session('user_name'))
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 48px; height: 48px; background: #6a3093; color: white; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; box-shadow: 0 2px 6px rgba(106,48,147,0.5); user-select: none;">
                        {{ substr(session('user_name'), 0, 1) }}
                    </div>
                    <span style="font-weight: 700; font-size: 1.1rem; white-space: nowrap;">مرحبًا، {{ session('user_name') }}</span>
                </div>
            @endif
            <span style="white-space: nowrap; font-size: 1rem;">
                <strong>رقم الهاتف:</strong> {{ session('phone') }}
            </span>
            <span style="white-space: nowrap; font-size: 1rem;">
                <strong>المهنة:</strong>
                @if(session('role') === 'vendor')
                    مدير متجر
                @elseif(session('role') === 'driver')
                    السائق
                @elseif(session('role') === 'admin')
                    المشرف
                @else
                    {{ session('role') }}
                @endif
            </span>
        </div>
    </nav>
</header>
<main class="container">
    @yield('content')
</main>
@stack('scripts')
</body>
</html>
