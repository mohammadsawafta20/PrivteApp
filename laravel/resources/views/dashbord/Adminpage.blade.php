<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title> صفحة الأدمن </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Orbitron&display=swap');

    .countdown {
      background: rgba(0, 0, 0, 0.7);
      padding: 30px 60px;
      border-radius: 10px;
     color: white;
      box-shadow: 0 0 3px #00ffd5aa;
      font-size: 4rem;
      letter-spacing: 0.15em;
      text-align: center;
      min-width: 380px;
      font-weight: 700;
      line-height: 1;
    }
    .label {
      font-size: 1.25rem;
      color:black;
      text-align: center;
      margin-bottom: 10px;
      font-weight: 500;
    }
  
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
      outline-offset: 4px;
    }
    .logout-button:hover,
    .logout-button:focus {
      background: linear-gradient(135deg, #4f46e5, #6366f1);
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(79, 70, 229, 0.6);
      outline: none;
    }
    .logout-button:active {
      transform: translateY(0);
      box-shadow: 0 4px 8px rgba(79, 70, 229, 0.5);
    }
    .logout-button:focus-visible {
      outline: 3px solid #c7d2fe;
      outline-offset: 4px;
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
        .datetime-box {
            background-color: #ffffff;
            padding: 30px 50px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .datetime-box h1 {
            margin: 0 0 10px;
            font-size: 24px;
            color: #333;
        }
        .datetime-box p {
            font-size: 20px;
            margin: 5px 0;
            color: #555;
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
    </style>


</head>
<body>

<header>
<!-- زر القائمة -->
<div class="menu-icon" onclick="toggleSidebar()">☰</div>

<!-- القائمة الجانبية -->
<div id="sidebar" class="sidebar" style="text-align:center;">
      <div class="profile-image"  >
<!-- مكان عرض صورة المستخدم -->
<img 
    src="{{ url('image/' . session('images')) }}" 
    alt="User Image"
    style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd; box-shadow: 0 2px 6px rgba(0,0,0,0.15);"
>
        <p style="padding:35px;" class="username"> {{ session('user_name') }}</p>

    </div>
    <a href="/ProfilePage">الملف الشخصي</a>
    <a href="/users">ادارة المستخدمين</a>
        <a href="/areas">ادارة المناطق</a>

    
             <a href="/orders">الطلبات </a>

       <a href="/development"> الصيانة</a>
        <a href="/dashboard">الخريطة</a>
        
        <a href="vendors/create">المتاجر</a>
          <a href="/drivers/create"> السائقين  </a>

    <br>
         <form action="{{ route('logout') }}" method="POST" id="logoutForm">
        @csrf
  <button class="logout-button" aria-label="تسجيل الخروج" style="
  background: linear-gradient(135deg, #6366f1, #4f46e5);
  border: none;
  border-radius: 12px;
  color: #ffffff;
  font-size: 1.1875rem;
  font-weight: 600;
  padding: 16px 32px;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
  transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
  user-select: none;
  outline-offset: 4px;
" onmouseover="this.style.background='linear-gradient(135deg, #4f46e5, #6366f1)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(79, 70, 229, 0.6)';" onmouseout="this.style.background='linear-gradient(135deg, #6366f1, #4f46e5)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(99, 102, 241, 0.4)';" onmousedown="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(79, 70, 229, 0.5)';" onmouseup="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(79, 70, 229, 0.6)';">
  تسجيل الخروج
</button>


    </form>
</div>

<!-- خلفية شفافة -->
<div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>




                <div style="display: flex; align-items: center; gap: 25px; font-family: 'Tajawal', sans-serif; background: #f5f5f7; padding: 12px 50px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); color: #4A4A4A; max-width: 600px;">

    @if(session('user_name'))
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 48px; height: 48px; background: #6a3093; color: white; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; box-shadow: 0 2px 6px rgba(106,48,147,0.5); user-select: none;">
                {{ substr(session('user_name'), 0, 1) }}
            </div>
            <span style="font-weight: 700; font-size: 1.1rem; white-space: nowrap;"> مرحبًا، {{ session('user_name') }}</span>
        </div>
    @endif



    <span style="white-space: nowrap; font-size: 1rem;">
        <strong>رقم الهاتف:</strong> {{ session('phone') }}
    </span>

    <span style="white-space: nowrap; font-size: 1rem;">
        <strong>المهنة:</strong>
        @if(session('role') === 'admin')
            المسؤول
        @else
            {{ session('role') }}
        @endif
    </span>

  <div>

  </div>
<div>

</div>



</header>
<div class="container" >

@auth
    <div style="position: fixed; top: 20px; right: 1200px; background: #fff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); z-index: 9999; display: flex; align-items: center;">
        <span style="font-weight: bold; margin-right: 10px;"> تقييمي :</span>
        <div style="color: gold; font-size: 22px;">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= Auth::user()->rating)
                    <i class="fas fa-star"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            @endfor
        </div>
    </div>
@endauth

    <div class="label"> الوقت المتبقي للدوام </div>
    <div class="countdown" aria-live="polite" role="timer" aria-atomic="true" id="countdown">08:00:00</div>
 


    <div class="stat-box">
        <h3> عدد الطلبات المرسله </h3>
        <p>{{ $ordersCount }}</p>
    </div>
    <div class="stat-box">
        <h3>عدد السائقين المتاحين</h3>
        <p>{{ $availableDriversCount }}</p>
    </div>

    <h2>طلبات المتاجر</h2>

    <table>
        <tr>
            <th>المتجر</th>
            <th>التفاصيل</th>
            <th>الموقع</th>
        </tr>
        @foreach($requests as $req)
            <tr>
                <td>{{ $req->store_name }}</td>
                <td>{{ $req->status }}</td>
                <td>{{ $req->latitude }},{{ $req->longitude }}</td>
        
            </tr>
        @endforeach
    </table>
</div>


 <script>
    (() => {
      const countdownEl = document.getElementById('countdown');
      const COUNTDOWN_DURATION_HOURS = 8;
      const STORAGE_KEY = 'countdownEndTimestamp';

      // دالة لتنسيق الوقت إلى hh:mm:ss
      function formatTime(seconds) {
        const hrs = Math.floor(seconds / 3600);
        const mins = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;
        return [
          hrs.toString().padStart(2, '0'),
          mins.toString().padStart(2, '0'),
          secs.toString().padStart(2, '0'),
        ].join(':');
      }

      // الحصول على الطابع الزمني الحالي بالمللي ثانية
      const now = Date.now();

      // التحقق من وجود وقت انتهاء مخزن في localStorage
      let endTimestamp = localStorage.getItem(STORAGE_KEY);
      if (endTimestamp) {
        endTimestamp = parseInt(endTimestamp, 10);
        // إذا كان الوقت المخزن في الماضي، نقوم بإزالته لإعادة بدء العد التنازلي
        if (endTimestamp <= now) {
          endTimestamp = null;
          localStorage.removeItem(STORAGE_KEY);
        }
      }

      // إذا لم يكن هناك وقت انتهاء مخزن، نقوم بتهيئة وقت انتهاء جديد وحفظه
      if (!endTimestamp) {
        endTimestamp = now + COUNTDOWN_DURATION_HOURS * 3600 * 1000;
        localStorage.setItem(STORAGE_KEY, endTimestamp.toString());
      }

      function updateCountdown() {
        const currentTime = Date.now();
        let remainingMs = endTimestamp - currentTime;
        if (remainingMs < 0) remainingMs = 0;
        const remainingSeconds = Math.floor(remainingMs / 1000);

        countdownEl.textContent = formatTime(remainingSeconds);

        if (remainingSeconds <= 0) {
          clearInterval(timer);
          // يمكن إزالة localStorage عند انتهاء العد التنازلي
          localStorage.removeItem(STORAGE_KEY);
        }
      }

      updateCountdown();
      const timer = setInterval(updateCountdown, 1000);
    })();
  
  </script>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (sidebar.style.width === '250px') {
            sidebar.style.width = '0';
            overlay.style.width = '0';
        } else {
            sidebar.style.width = '250px';
            overlay.style.width = '100%';
        }
    }
</script>

</body>
</html>
