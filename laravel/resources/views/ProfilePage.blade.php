<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title> صفحة نعديل البيانات </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    padding: 0px;
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
            height: 20px;
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
.profile-container {
    max-width: 600px;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 0 10px #ccc;
    direction: rtl;
    font-family: 'Cairo', sans-serif;
}

.profile-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #444;
}

.alert.success {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
}

.image-section {
    text-align: center;
    margin-bottom: 20px;
}

.image-section img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
    margin-bottom: 10px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}


.form-group input {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn-submit {
    display: block;
    width: 100%;
    padding: 10px;
    background: #1877f2;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background: #165ec9;
}

.profile-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            direction: rtl;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .success-message
        {
        color: green;
        size: 20px;
        
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .image-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .image-section img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 12px;
            background: #1877f2;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #165ec9;
        }


    </style>

</head>
<body>

<header>

<!-- خلفية شفافة -->
<div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>


    <div class="logo"></div>
    <nav>

    </nav>
  <div>

  </div>

</header>

     <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
<br>


        {{-- رسالة النجاح --}}
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        {{-- عرض الأخطاء --}}
        @if($errors->any())
            <div class="error-message">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="image-section">
           <img 
    src="{{ url('image/' . session('images')) }}" 
    alt="User Image"
    style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd; box-shadow: 0 2px 6px rgba(0,0,0,0.15);"
>
        </div>

        <div   dir="rtl"   class="form-group">
            <label for="name">الاسم:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">البريد الإلكتروني:</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div dir="rtl"   class="form-group">
           <label for="phone">رقم الهاتف:</label>
        <input  dir="rtl"  type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>
              <div class="form-group">
           <label for="password">كلمة المرور: <small>(اتركها فارغة إذا لم ترغب في التغيير)</small></label>
        <input type="password" id="password" name="password" autocomplete="new-password">

        <label for="password_confirmation">تأكيد كلمة المرور:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
        </div>
   <label for="profile_image">الصورة الشخصية:</label><br>
        <input type="file" id="profile_image" name="profile_image" class="form-control" accept="image/*">
        
        <button type="submit" class="btn-submit">تحديث</button>
    </form>
</div>

</div>




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
