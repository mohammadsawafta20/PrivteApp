<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إرسال طلب جديد</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* التصميم العام */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4B0082;
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            padding: 30px;
        }

        .form-box {

            background-color: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            margin: 0 auto;
        }

        .form-box input, .form-box textarea, .form-box select, .form-box button {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
        }

        .form-box button {
            background-color: #4B0082;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-box button:hover {
            background-color: #6A0DAD;
        }

        /* التنبيه */
        #successMessage {
            background-color: #4BB543;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة المستخدم - دلفري للتوصيل</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');

        :root {
            --main-color: #6a3093;
            --secondary-color: #a044ff;
            --text-color: #333;
            --light-bg: #f8f9fa;
        }

        * {
            font-family: 'Tajawal', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--light-bg);
            color: var(--text-color);
        }

        /* الهيدر */
        .user-header {
            background: linear-gradient(to left, var(--main-color), var(--secondary-color));
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .welcome-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .logout-btn {
            background-color: transparent;
            color: white;
            border: 1px solid white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background-color: rgba(255,255,255,0.2);
        }

        /* محتوى الصفحة */
        .container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-title {
            color: var(--main-color);
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--main-color);
        }

        /* جدول الطلبات */
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        .orders-table th, .orders-table td {
            padding: 1rem;
            text-align: right;
            border-bottom: 1px solid #eee;
        }

        .orders-table th {
            background-color: var(--main-color);
            color: white;
            font-weight: 500;
        }

        .orders-table tr:hover {
            background-color: #f5f5f5;
        }

        .status {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-canceled {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* رسالة عدم وجود طلبات */
        .no-orders {
            text-align: center;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .user-header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .orders-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <!-- الهيدر -->
    <header class="user-header">
        <div class="welcome-section">



                <div class="user-avatar" style="background-color: white; display: flex; justify-content: center; align-items: center;">
                    <i class="fas fa-user" style="color: var(--main-color);"></i>
                </div>

            <div>

                <small>لوحة   ارسال الطلب </small>
            </div>
        </div>


    </header>
  <!-- تنبيه عند نجاح الإرسال -->
  @if(session('success'))
  <div class="alert alert-success">
      {{ session('success') }}
  </div>
@endif

    <!-- المحتوى الرئيسي -->
    <div class="container">




  <div class="form-box">
      <h3>إرسال طلب</h3>

      <form action="{{ route('insertrequest.storerequest') }}" method="POST">
          @csrf
          <input type="text" name="store_name" id="store_name"placeholder="اسم المتجر " value="{{ old('store_name', $storeName) }}"  readonly>

          <label for="location">مكان التوصيل:</label>    <select name="location" id="location" required>
                    <option value="" disabled selected>اختر مكان التوصيل</option>
                    <option value="جبل عمان">جبل عمان</option>
                    <option value="القواسمي">القواسمي</option>
                    <option value="الزهرة">الزهرة</option>
                    <option value="ام الريحان">ام الريحان</option>
                    <option value="الهلال">الهلال</option>
                    <option value="حي نزال">حي نزال</option>
                    <option value="clear">تفريغ الحقول</option>  <!-- الخيار الجديد -->

                </select>

               سعر التوصيل : <input type="text" name="delivery_price" id="delivery_price" placeholder="سعر التوصيل" readonly required>
                سعر الطلب :<input type="number" name="order_price" id="order_price" placeholder="سعر الطلب" required>
            السعر الكلي :    <input type="text" name="total_price" id="total_price" placeholder="السعر الكلي" readonly required>
             <input type="text" name="phone_number" id="phone_number" placeholder="رقم الهاتف" required>
          <label for="details"> الملاحظات:</label>
          <textarea name="details" id="details" rows="4" required></textarea>

          <label for="latitude">خط العرض:</label>
          <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', $latitude) }}" readonly>

          <label for="longitude">خط الطول:</label>
          <input type="number" step="any" name="longitude"  value="{{ old('longitude', $longitude) }}" id="longitude" readonly>

          <label for="status"> الحالة:</label>
          <select name="status" id="status" required>
              <option value="pending"> مدفوع</option>
              <option value="in_progress">عبر مدفوع </option>
          </select>

          <button type="submit" onclick="cancelForm()">إلغاء </button>
          <button type="submit">إرسال الطلب</button>
      </form>


    </div>
    <script>
        function cancelForm() {
          // Redirect to the homepage
          window.location.href = '/VendorPage';
        }
      </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




<script>
    // إخفاء التنبيه بعد 5 ثواني
    setTimeout(function() {
        var successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 5000);
</script>
<script>
 // أسعار التوصيل لكل منطقة
        const deliveryPrices = {
            'جبل عمان': 10.00,
            'القواسمي': 15.50,
            'الزهرة': 20.00,
            'ام الريحان': 12.75,
            'الهلال': 8.00,
            'حي نزال': 18.00
        };
        const locationSelect = document.getElementById('location');
        const deliveryPriceInput = document.getElementById('delivery_price');
        const orderPriceInput = document.getElementById('order_price');
        const totalPriceInput = document.getElementById('total_price');
        // تحديث سعر التوصيل عند تغيير مكان التوصيل
        locationSelect.addEventListener('change', () => {
        const selectedLocation = locationSelect.value;

        if (selectedLocation === 'clear') {
            // تفريغ الحقول عند اختيار "تفريغ الحقول"
            locationSelect.value = '';  // إعادة اختيار فارغ
            deliveryPriceInput.value = '';
            orderPriceInput.value = '';
            totalPriceInput.value = '';
        } else {
            // تعبئة سعر التوصيل حسب المنطقة المختارة
            deliveryPriceInput.value = deliveryPrices[selectedLocation] || '';
            updateTotalPrice();
        }
    });
        // تحديث السعر الكلي
        orderPriceInput.addEventListener('input', updateTotalPrice);
        function updateTotalPrice() {
            const deliveryPrice = parseFloat(deliveryPriceInput.value) || 0;
            const orderPrice = parseFloat(orderPriceInput.value) || 0;
            const totalPrice = deliveryPrice + orderPrice;
            totalPriceInput.value = totalPrice.toFixed(2); // عرض السعر مع نقطتين عشريتين
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
