<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة تتبع الطلبات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
    
    html, body {
  height: 100%;
  margin: 0;
  padding: 0;
  direction: rtl;
  font-family: Arial, sans-serif;
}





body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
    text-align: center;

}

/* اجعل stats-container ارتفاعه تلقائي */
.stats-container {
  flex: 0 0 auto; /* ارتفاع حسب المحتوى */
  /* باقي التنسيقات موجودة */
}

/* اجعل الخريطة تأخذ باقي المساحة */
#map {
  flex: 1 1 auto; /* يأخذ كل المساحة المتبقية */
  min-height: 300px; /* ارتفاع ادنى مناسب للشاشات الصغيرة */
}

        #map { height: 100vh; 
             flex: 1;
  min-height: 400px;
  border: 2px solid #3498db;
  border-radius: 15px;
  margin: 10px 0;
  padding:20px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        #assignModal {
            display: none;
            position: fixed;
            top: 20%;
            left: 30%;
            width: 300px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            z-index: 1000;
        }
        /* ملف stats.css */
.stats-header {
  background-color: #f8f9fa;
  padding: 10px 20px;
  border-bottom: 2px solid #ddd;
  position: sticky;
  top: 0;
  z-index: 1000;
}

.stats-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap; /* يجعل المحتوى يتكيف في حال صغر الشاشة */
  gap: 15px;
}

.stat-box {
  flex: 1;
  min-width: 120px;
  background-color: #ffffff;
  border-radius: 10px;
  padding: 10px 15px;
  text-align: center;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  transition: transform 0.2s;
}

.stat-box:hover {
  transform: scale(1.05);
}

.stat-box h3 {
  font-size: 14px;
  color: #333;
  margin-bottom: 5px;
}

.stat-box p {
  font-size: 20px;
  font-weight: bold;
  color: #007bff;
}


    </style>
</head>
<header class="stats-header">
  <div class="stats-container">
    <div class="stat-box" title="الطلبات المرسلة">
      <h3>الطلبات المرسلة</h3>
      <p>{{ $stats['assigned_orders'] }}</p>
    </div>
    <div class="stat-box" title="عدد الطلبات">
      <h3>عدد الطلبات</h3>
      <p id="available-drivers">{{ $stats['total_orders'] }}</p>
    </div>
    <div class="stat-box" title="الطلبات المكتملة">
      <h3>الطلبات المكتملة</h3>
      <p>{{ $stats['completed_orders'] }}</p>
    </div>
    <div class="stat-box" title="الطلبات الملغاة">
      <h3><a href="https://privateapp.online/orders">الطلبات الملغاة</a></h3>
      <p>{{ $stats['cancelled_orders'] }}</p>
    </div>
    <div class="stat-box" title="عدد السائقين المتاحين">
      <h3>السائقين المتاحين</h3>
      <p>{{ $stats['total_drivers'] }}</p>
    </div>
    <div class="stat-box" title="عدد المتاجر">
      <h3>عدد المتاجر</h3>
      <p>{{ $stats['total_vendors'] }}</p>
    </div>
  </div>
</header>

<body>

<div id="assignModal">
    <h4>اختر سائق لتوصيل الطلب</h4>
    <select id="driverSelect"></select><br><br>
    <button onclick="assignDriver()">تأكيد</button>
    <button onclick="closeAssignModal()">إلغاء</button>
</div>

    <div id="map">
        
<audio  id="orderSound"  controls preload="auto" src="{{ url('/audio/send.mp3') }}"></audio>

    <script>
        const map = L.map('map').setView([31.9539, 35.9106], 12); // عمان، الأردن

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

       
        let driverMarkers = [];
        let selectedVendorId = null;
        let vendorMarkers = []; // خارج الدالة

let vendorMarkersMap = {}; // لتخزين الماركرات حسب ID المتجر
let notifiedVendors = new Set(); // لمنع تكرار التنبيهات

function loadVendorsWithStatus() {
        const newVendorIds = new Set();  // <- عرف المتغير هنا

    fetch('https://privateapp.online/api/vendors/with-status')
        .then(response => response.json())
        .then(data => {
            if (data.status) {

                data.vendors.forEach(vendor => {
                    const id = vendor.id;
                    const lat = vendor.latitude;
                    const lng = vendor.longitude;
                    const name = vendor.name;
                    const phone = vendor.phone;
                    const hasPending = vendor.has_pending_orders;
                    const pendingCount = vendor.pending_orders_count;

                    const iconUrl = hasPending
                        ? 'https://cdn-icons-png.flaticon.com/512/7511/7511662.png'
                        : 'https://cdn-icons-png.flaticon.com/512/7511/7511667.png';

                    const icon = L.icon({
                        iconUrl: iconUrl,
                        iconSize: [30, 40],
                        iconAnchor: [15, 40],
                        popupAnchor: [0, -40]
                    });

                    newVendorIds.add(id);

      
                    if (vendorMarkersMap[id]) {
                        // تحديث الموقع والأيقونة
                        vendorMarkersMap[id].setLatLng([lat, lng]);
                        vendorMarkersMap[id].setIcon(icon);
                        vendorMarkersMap[id].setPopupContent(`
                            <strong>${name}</strong><br>
                            عدد الطلبات المعلقة: ${pendingCount}<br>
                            الهاتف: ${phone}
                        `);
                        // ✅ تشغيل تنبيه صوتي ومرئي فقط لأول مرة عند الطلب الجديد
if (hasPending && !notifiedVendors.has(id)) {
    notifiedVendors.add(id);
    showNewOrderAlert(); // تنبيه بصري (مثل Toast)
    playOrderSound();    // تنبيه صوتي
}
             
             
                    } else {
                        // إضافة ماركر جديد
                        const marker = L.marker([lat, lng], { icon: icon })
                            .addTo(map)
                            .bindPopup(`
                                <strong>${name}</strong><br>
                                عدد الطلبات المعلقة: ${pendingCount}<br>
                                الهاتف: ${phone}
                            `);


                        // إذا كان لديه طلبات معلقة، اجعل الماركر قابل للنقر لإسناد السائق
                        if (hasPending) {
                            marker.on('click', () => openAssignModal(id));
                        }

                        vendorMarkersMap[id] = marker;
                    }
                });

                // إزالة المتاجر التي لم تعد موجودة
                for (const id in vendorMarkersMap) {
                    if (!newVendorIds.has(Number(id))) {
                        map.removeLayer(vendorMarkersMap[id]);
                        delete vendorMarkersMap[id];
                    }
                }

            } else {
                console.warn('⚠️ فشل في تحميل بيانات المتاجر');
            }
        })
        .catch(err => {
            console.error('❌ خطأ في تحميل المتاجر:', err);
        });
}

let driverMarkersMap = {}; // بدلاً من مصفوفة، استخدم map لتخزين الماركرات بالسائق ID

function loadOnlineDrivers() {
    fetch('https://privateapp.online/api/Drivers/online')
        .then(res => res.json())
        .then(data => {
            const newDriverIds = new Set();

            data.forEach(driver => {
                const id = driver.id;
                const lat = driver.latitude;
                const lng = driver.longitude;
                const name = driver.user.name;
                const phone = driver.user.phone;
                const isAssigned = driver.order && driver.order.status === 'assigned';

                const icon = L.icon({
                    iconUrl: isAssigned
                        ? 'https://cdn-icons-png.flaticon.com/512/4214/4214491.png'
                        : 'https://cdn-icons-png.flaticon.com/512/1048/1048339.png',
                    iconSize: [50, 45]
                });

                newDriverIds.add(id);

                if (driverMarkersMap[id]) {
                    // إذا كان الماركر موجود: حدث موقعه ورمزه
                    driverMarkersMap[id].setLatLng([lat, lng]);
                    driverMarkersMap[id].setIcon(icon);
                } else {
                    // إذا لم يكن موجود: أضفه
                    const marker = L.marker([lat, lng], { icon: icon })
                        .addTo(map)
                        .bindPopup(`<b>${name}</b><br>📞 ${phone}`);
                    driverMarkersMap[id] = marker;
                }
            });

            // إزالة السائقين غير المتصلين الآن
            for (const id in driverMarkersMap) {
                if (!newDriverIds.has(Number(id))) {
                    map.removeLayer(driverMarkersMap[id]);
                    delete driverMarkersMap[id];
                }
            }
        })
        .catch(err => {
            console.error('❌ فشل تحميل السائقين:', err);
        });
}

        function openAssignModal(vendorId) {

            selectedVendorId = vendorId;
            fetch('https://privateapp.online/api/Drivers/online')
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById('driverSelect');
                    select.innerHTML = '';
                    data.forEach(driver => {
                        select.innerHTML += `<option value="${driver.id}">${driver.user.name} (${driver.user.phone})</option>`;
                    });
                    document.getElementById('assignModal').style.display = 'block';
                });
        }

        function closeAssignModal() {
            document.getElementById('assignModal').style.display = 'none';
            selectedVendorId = null;
        }
        
        function assignDriver() {
            const driverId = document.getElementById('driverSelect').value;
            fetch('https://privateapp.online/api/orders/assign', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    vendor_id: selectedVendorId,
                    driver_id: driverId
                })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                closeAssignModal();
                updateMapData();
            })
            .catch(err => {
                alert('❌ حدث خطأ أثناء الإسناد');
                console.error(err);
            });
        }
        function playOrderSound() {
    const audio = document.getElementById('orderSound');
    if (audio) audio.play().catch(e => console.log("🎵 لم يتم تشغيل الصوت:", e));
}

function showNewOrderAlert() {
    const alertBox = document.createElement('div');

    // محتوى التنبيه مع رمز وعداد تنازلي
    alertBox.innerHTML = `
      <strong style="font-size: 18px;">📦 يوجد طلب جديد من متجر!</strong>
      <div style="margin-top: 5px; font-size: 14px; color: #555;">
        تغلق خلال <span id="countdown">40</span> ثانية
      </div>
    `;

    // تصميم التنبيه
    Object.assign(alertBox.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        background: 'linear-gradient(135deg, #f39c12, #f1c40f)', // تدرج لوني أصفر ذهبي
        color: '#222',
        padding: '15px 25px',
        borderRadius: '12px',
        boxShadow: '0 4px 15px rgba(243, 156, 18, 0.6)',
        fontFamily: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif",
        zIndex: '9999',
        minWidth: '250px',
        userSelect: 'none',
    });

    document.body.appendChild(alertBox);

    let timeLeft = 40;
    const countdownEl = alertBox.querySelector('#countdown');

    const intervalId = setInterval(() => {
        timeLeft--;
        countdownEl.innerText = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(intervalId);
            alertBox.remove();
        }
    }, 1000);
}


        function updateMapData() {
            loadVendorsWithStatus();
            loadOnlineDrivers();
        }



        updateMapData();
       setInterval(loadVendorsWithStatus, 10000); // كل 10 ثواني
setInterval(loadOnlineDrivers, 10000);    
        </script>
    
    </div>
</body>
</html>
