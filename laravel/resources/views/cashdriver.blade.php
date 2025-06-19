<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title> لوحة السائق </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        .centered-alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fffae6;
            color: #333;
            border: 2px solid #ffcc00;
            padding: 30px 40px;
            border-radius: 12px;
            z-index: 9999;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-in-out;
            text-align: center;
        }

        .alert-content .icon {
            font-size: 40px;
            margin-bottom: 10px;
            display: block;
            animation: pulse 1.2s infinite;
        }
        .logout-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background-color: red;
    color: white;
    border: none;
    width:100px;
    margin-right:  50px;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.logout-btn:hover {
    background-color: green;
}

.logout-btn i {
    font-size: 10px;
}

/* القائمة الجانبية */
.menu-icon {
    font-size: 30px;
    cursor: pointer;
    padding: 20px;
    position: fixed;
    left: 10px;
    top: 8px;
    z-index: 1001;
    color: white;
}

.sidebar {
    height: 100%;
    width: 0;
    position: fixed;
    left: 0;
    top: 0;
    background-color: #333;
    overflow-x: hidden;
    transition: 0.3s;
    padding-top: 60px;
    z-index: 1000;
}

.sidebar a {
    padding: 15px 25px;
    text-decoration: none;
    font-size: 18px;
    color: white;
    display: block;
    transition: 0.3s;
}

.sidebar a:hover {
    background-color: #575757;
}

.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 0;
    background: rgba(0, 0, 0, 0.4);
    transition: 0.3s;
    z-index: 999;
}

        .close-btn {
            background-color: #ffcc00;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .close-btn:hover {
            background-color: #e6b800;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -60%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f4f8;
        }

        header {
            background-color: #4B0082;
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            margin: 50px;
            color: white;
            margin-left: 15px;
            text-decoration: none;
        }

        .container {
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #eee;
            font-weight: bold;
        }

        a.button,
        button.button {
            padding: 6px 12px;
            background-color: #4B0082;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
        }

        button.button {
            border: none;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }

        select, button {
            padding: 8px;
            margin-top: 10px;
            width: 80%;
        }

        .close {
            float: left;
            font-size: 20px;
            color: #999;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }


.profile-image {
    margin: 50px;

}

.profile-image img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 2px solid #ddd;
}

.username {
    margin-top: 10px;
    font-weight: bold;
    color: #333;
}

    </style>

</head>
<body>

<header>
<!-- زر القائمة -->
<div class="menu-icon" onclick="toggleSidebar()">☰</div>

<!-- القائمة الجانبية -->
<div id="sidebar" class="sidebar">

    <a href="/contact">التواصل مع الدعم</a>
     <!-- صورة المستخدم -->
    <div class="profile-image">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMPiZw9s7cz-zlkqLs7mv1p_4GGKFDmMmUDpOD0z2Ak5L8JHQvgv6rlwYLCq_v_ROJ1e4&usqp=CAU" alt="صورة المستخدم">
        <p class="username">اسم المستخدم</p>
    </div>

    <a href="/ProfilePage">الملف الشخصي</a>
    <a href="/driver/info">المحفظه</a>
    <a href="/orders"> طلباتي</a>
    <a href="/userpage">طلب جديد  </a>
    <br>
         <form action="{{ route('logout') }}" method="POST" id="logoutForm">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>تسجيل الخروج</span>
        </button>
    </form>
</div>

<!-- خلفية شفافة -->
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
        <strong> المهنة :</strong>
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
  <div>

  </div>

</header>
<style>
    .driver-stats {
        display: flex;
        gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .stat-card {
        flex: 1;
        min-width: 200px;
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        text-align: center;
    }

    .stat-card h3 {
        padding: 15px;
        font-size: 24px;
        margin: 10px 0;
    }

    .stat-icon {
        font-size: 40px;
        margin-bottom: 10px;
        display: block;
    }

    .stat-label {
        font-size: 16px;
        color: #555;
    }
    .action-buttons {
    margin-top: 30px;
    text-align: center;
}

.action-buttons a {
    padding: 10px 25px;
    margin: 0 10px;
    border-radius: 8px;
    font-size: 16px;
    color: white;
    text-decoration: none;
    transition: background-color 0.3s ease;
    display: inline-block;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.btn-deposit {
    background-color: #28a745;
}

.btn-deposit:hover {
    background-color: #218838;
}

.btn-withdraw {
    background-color: #dc3545;
}

.btn-withdraw:hover {
    background-color: #c82333;
}

</style>

<h2>بيانات السائق:</h2>

<div class="driver-stats">

    <div class="stat-card">
        <span class="stat-icon">💰</span>
        <h3>{{ number_format($driverData['wallet_balance'], 2) }} <span style="font-size: 16px;">₪</span></h3>
        <div class="stat-label">الرصيد</div>
    </div>

<div class="stat-card">
    <span class="stat-icon">⭐</span>
    <div class="star-rating">
        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= floor($driverData['rating']))
                <span class="star filled">⭐<span>
            @else
                <span class="star">☆</span>
            @endif
        @endfor
    </div>
    <div class="stat-label">التقييم</div>
</div>

    <div class="stat-card">
        <span class="stat-icon">🎁</span>
        <h3>{{ $driverData['discount'] }}دينار</h3>
        <div class="stat-label">الخصم</div>
    </div>

</div>
<div class="action-buttons">
    <a href="#" class="btn-deposit">
        💵 إيداع
    </a>

    <a href="#" class="btn-withdraw">
        🏧 سحب
    </a>
</div>

</body>
</html>
