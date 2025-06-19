// بيانات التطبيق
const appData = {
    stores: [
        {
            id: 1,
            name: "متجر الأجهزة الكهربائية",
            phone: "0791234567",
            lat: 31.9454,
            lng: 35.9284,
            hasOrder: false
        },
        {
            id: 2,
            name: "سوبر ماركت المدينة",
            phone: "0797654321",
            lat: 31.9554,
            lng: 35.9184,
            hasOrder: false
        },
        {

            id: 3,
            name: "سوبر  التوحيد",
            phone: "0797654321",
            lat: 31.940015,
            lng: 35.933224,
            hasOrder: false
        }
    ],
    drivers: [
        {
            id: 1,
            name: "أحمد محمد",
            phone: "0781112233",
            lat: 31.9504,
            lng: 35.9204,
            hasOrder: false
        },
        {
            id: 2,
            name: "خالد علي",
            phone: "0784445566",
            lat: 31.9404,
            lng: 35.9304,
            hasOrder: false
        },
        {
            id: 3,
            name: "محمد صوافطة ",
            phone: "0595690872",
            lat: 31.896886,
            lng: 35.840527,
            hasOrder: false
        }
    ],
    orders: [],
    map: null,
    storeMarkers: [],
    driverMarkers: []
};

// تهيئة الخريطة
function initMap() {
    // مركز الخريطة عمان، الأردن
    appData.map = L.map('map').setView([31.9454, 35.9284], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(appData.map);

    // إضافة المتاجر إلى الخريطة
    updateStoresOnMap();

    // إضافة السائقين إلى الخريطة
    updateDriversOnMap();

    // محاكاة طلب جديد كل 30 ثانية (لأغراض العرض)
    setInterval(simulateNewOrder, 30000);

    // عرض أي طلبات موجودة بالفعل
    updateOrdersList();
    updateAvailableDrivers();

    // إضافة حدث النقر على الخريطة لإنشاء طلب جديد (لأغراض العرض)
    appData.map.on('click', function(e) {
        // في تطبيق حقيقي، سيكون هذا من خلال واجهة المتجر
        simulateNewOrderAtLocation(e.latlng.lat, e.latlng.lng);
    });
}

// تحديث المتاجر على الخريطة
function updateStoresOnMap() {
    // إزالة العلامات القديمة
    appData.storeMarkers.forEach(marker => appData.map.removeLayer(marker));
    appData.storeMarkers = [];

    // إضافة العلامات الجديدة
    appData.stores.forEach(store => {
        const icon = L.divIcon({
            className: store.hasOrder ? 'assigned-store' : 'store-icon',
            html: `<span>${store.name}</span>`,
            iconSize: [20, 20]
        });

        const marker = L.marker([store.lat, store.lng], { icon: icon })
            .addTo(appData.map)
            .bindPopup(`
                <b>${store.name}</b><br>
                الهاتف: ${store.phone}<br>
                ${store.hasOrder ? '<span class="text-warning">لديه طلب نشط</span>' : 'لا يوجد طلبات'}
            `);

        appData.storeMarkers.push(marker);
    });
}

// تحديث السائقين على الخريطة
function updateDriversOnMap() {
    // إزالة العلامات القديمة
    appData.driverMarkers.forEach(marker => appData.map.removeLayer(marker));
    appData.driverMarkers = [];

    // إضافة العلامات الجديدة
    appData.drivers.forEach(driver => {
        const icon = L.divIcon({
            className: driver.hasOrder ? 'assigned-driver' : 'driver-icon',
            html: `<span>${driver.name}</span>`,
            iconSize: [20, 20]
        });

        const marker = L.marker([driver.lat, driver.lng], { icon: icon })
            .addTo(appData.map)
            .bindPopup(`
                <b>${driver.name}</b><br>
                الهاتف: ${driver.phone}<br>
                ${driver.hasOrder ? '<span class="text-danger">مشغول بتوصيل طلب</span>' : 'متاح'}
            `);

        appData.driverMarkers.push(marker);
    });
}

// محاكاة طلب جديد (لأغراض العرض)
function simulateNewOrder() {
    if (appData.stores.length === 0) return;

    const randomStoreIndex = Math.floor(Math.random() * appData.stores.length);
    const store = appData.stores[randomStoreIndex];

    // إحداثيات عشوائية قريبة من المتجر لعنوان التسليم
    const deliveryLat = store.lat + (Math.random() * 0.01 - 0.005);
    const deliveryLng = store.lng + (Math.random() * 0.01 - 0.005);

    createNewOrder(store.id, deliveryLat, deliveryLng);
}

// محاكاة طلب جديد في موقع معين
function simulateNewOrderAtLocation(lat, lng) {
    if (appData.stores.length === 0) return;

    const randomStoreIndex = Math.floor(Math.random() * appData.stores.length);
    const store = appData.stores[randomStoreIndex];

    createNewOrder(store.id, lat, lng);
}

// إنشاء طلب جديد
function createNewOrder(storeId, deliveryLat, deliveryLng) {
    const store = appData.stores.find(s => s.id === storeId);
    if (!store) return;

    const newOrder = {
        id: Date.now(),
        storeId: store.id,
        storeName: store.name,
        storePhone: store.phone,
        deliveryLat: deliveryLat,
        deliveryLng: deliveryLng,
        driverId: null,
        driverName: null,
        status: "pending",
        createdAt: new Date()
    };

    appData.orders.push(newOrder);
    store.hasOrder = true;

    updateStoresOnMap();
    updateOrdersList();
    showNewOrderNotification(newOrder);
}

// عرض إشعار بطلب جديد
function showNewOrderNotification(order) {
    const notification = document.createElement('div');
    notification.className = 'alert alert-info alert-dismissible fade show notification';
    notification.innerHTML = `
        <strong>طلب جديد!</strong> من ${order.storeName}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <div class="mt-2">
            <button class="btn btn-sm btn-primary view-order-btn" data-order-id="${order.id}">عرض التفاصيل</button>
        </div>
    `;

    document.body.appendChild(notification);

    // إضافة حدث النقر لزر العرض
    notification.querySelector('.view-order-btn').addEventListener('click', function() {
        showOrderDetailsModal(order.id);
    });

    // إزالة الإشعار بعد 10 ثواني
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 150);
    }, 10000);
}

// عرض تفاصيل الطلب في المودال
function showOrderDetailsModal(orderId) {
    const order = appData.orders.find(o => o.id === orderId);
    if (!order) return;

    document.getElementById('modal-store-name').textContent = order.storeName;
    document.getElementById('modal-store-phone').textContent = order.storePhone;
    document.getElementById('modal-delivery-address').textContent = `(${order.deliveryLat.toFixed(4)}, ${order.deliveryLng.toFixed(4)})`;

    // تعبئة قائمة السائقين المتاحين
    const driverSelect = document.getElementById('driver-select');
    driverSelect.innerHTML = '';

    const availableDrivers = appData.drivers.filter(d => !d.hasOrder);
    availableDrivers.forEach(driver => {
        const option = document.createElement('option');
        option.value = driver.id;
        option.textContent = `${driver.name} - ${driver.phone}`;
        driverSelect.appendChild(option);
    });

    // حفظ معرف الطلب في زر التعيين
    document.getElementById('assign-driver-btn').dataset.orderId = order.id;

    // عرض المودال
    const modal = new bootstrap.Modal(document.getElementById('orderModal'));
    modal.show();
}

// تعيين سائق للطلب
function assignDriverToOrder(orderId, driverId) {
    const order = appData.orders.find(o => o.id === orderId);
    const driver = appData.drivers.find(d => d.id === driverId);
    const store = appData.stores.find(s => s.id === order.storeId);

    if (!order || !driver || !store) return;

    order.driverId = driver.id;
    order.driverName = driver.name;
    order.status = "assigned";
    driver.hasOrder = true;

    // تحديث الخريطة والقوائم
    updateStoresOnMap();
    updateDriversOnMap();
    updateOrdersList();
    updateAvailableDrivers();

    // محاكاة توصيل الطلب بعد 2 دقيقة
    setTimeout(() => completeOrder(orderId), 120000);
}

// إكمال الطلب
function completeOrder(orderId) {
    const order = appData.orders.find(o => o.id === orderId);
    const driver = appData.drivers.find(d => d.id === order.driverId);
    const store = appData.stores.find(s => s.id === order.storeId);

    if (!order || !driver || !store) return;

    order.status = "completed";
    driver.hasOrder = false;
    store.hasOrder = false;

    // تحديث الخريطة والقوائم
    updateStoresOnMap();
    updateDriversOnMap();
    updateOrdersList();
    updateAvailableDrivers();
}

// تحديث قائمة الطلبات الجديدة
function updateOrdersList() {
    const newOrdersContainer = document.getElementById('new-orders');
    if (!newOrdersContainer) return;

    const pendingOrders = appData.orders.filter(o => o.status === "pending");

    if (pendingOrders.length === 0) {
        newOrdersContainer.innerHTML = '<p>لا توجد طلبات جديدة</p>';
        return;
    }

    newOrdersContainer.innerHTML = '';
    pendingOrders.forEach(order => {
        const orderElement = document.createElement('div');
        orderElement.className = 'card mb-2';
        orderElement.innerHTML = `
            <div class="card-body">
                <h5 class="card-title">طلب #${order.id}</h5>
                <p class="card-text">
                    <strong>من:</strong> ${order.storeName}<br>
                    <strong>هاتف:</strong> ${order.storePhone}
                </p>
                <button class="btn btn-sm btn-primary assign-driver-btn" data-order-id="${order.id}">تعيين سائق</button>
            </div>
        `;

        orderElement.querySelector('.assign-driver-btn').addEventListener('click', function() {
            showOrderDetailsModal(order.id);
        });

        newOrdersContainer.appendChild(orderElement);
    });
}

// تحديث قائمة السائقين المتاحين
function updateAvailableDrivers() {
    const driversContainer = document.getElementById('available-drivers');
    if (!driversContainer) return;

    const availableDrivers = appData.drivers.filter(d => !d.hasOrder);

    if (availableDrivers.length === 0) {
        driversContainer.innerHTML = '<p>لا يوجد سائقون متاحون</p>';
        return;
    }

    driversContainer.innerHTML = '';
    availableDrivers.forEach(driver => {
        const driverElement = document.createElement('div');
        driverElement.className = 'card mb-2';
        driverElement.innerHTML = `
            <div class="card-body">
                <h5 class="card-title">${driver.name}</h5>
                <p class="card-text">${driver.phone}</p>
            </div>
        `;
        driversContainer.appendChild(driverElement);
    });
}

// تحديث لوحة التحكم
function updateAdminDashboard() {
    document.getElementById('stores-count').textContent = appData.stores.length;
    document.getElementById('drivers-count').textContent = appData.drivers.length;
    document.getElementById('orders-count').textContent = appData.orders.length;

    // تحديث جدول الطلبات
    const ordersTableBody = document.getElementById('orders-table-body');
    if (ordersTableBody) {
        ordersTableBody.innerHTML = '';

        appData.orders.forEach(order => {
            const row = document.createElement('tr');

            let statusClass = '';
            let statusText = '';
            switch (order.status) {
                case 'pending':
                    statusClass = 'text-warning';
                    statusText = 'بانتظار السائق';
                    break;
                case 'assigned':
                    statusClass = 'text-primary';
                    statusText = 'تم التعيين';
                    break;
                case 'completed':
                    statusClass = 'text-success';
                    statusText = 'مكتمل';
                    break;
            }

            row.innerHTML = `
                <td>${order.id}</td>
                <td>${order.storeName}</td>
                <td>${order.storePhone}</td>
                <td>(${order.deliveryLat.toFixed(4)}, ${order.deliveryLng.toFixed(4)})</td>
                <td>${order.driverName || '--'}</td>
                <td class="${statusClass}">${statusText}</td>
                <td>${order.createdAt.toLocaleString()}</td>
            `;

            ordersTableBody.appendChild(row);
        });
    }
}

// إضافة متجر جديد
function addNewStore(name, phone, lat, lng) {
    const newStore = {
        id: Date.now(),
        name: name,
        phone: phone,
        lat: parseFloat(lat),
        lng: parseFloat(lng),
        hasOrder: false
    };

    appData.stores.push(newStore);
    updateStoresOnMap();
    updateAdminDashboard();

    // إظهار رسالة نجاح
    alert('تم إضافة المتجر بنجاح!');
}

// إضافة سائق جديد
function addNewDriver(name, phone, lat, lng) {
    const newDriver = {
        id: Date.now(),
        name: name,
        phone: phone,
        lat: parseFloat(lat),
        lng: parseFloat(lng),
        hasOrder: false
    };

    appData.drivers.push(newDriver);
    updateDriversOnMap();
    updateAdminDashboard();

    // إظهار رسالة نجاح
    alert('تم إضافة السائق بنجاح!');
}

// تهيئة الأحداث عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    // إذا كانت هذه صفحة الخريطة
    if (document.getElementById('map')) {
        initMap();
    }

    // إذا كانت هذه صفحة لوحة التحكم
    if (document.getElementById('add-store-form')) {
        updateAdminDashboard();

        // إضافة متجر جديد
        document.getElementById('add-store-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('store-name').value;
            const phone = document.getElementById('store-phone').value;
            const lat = document.getElementById('store-lat').value;
            const lng = document.getElementById('store-lng').value;

            addNewStore(name, phone, lat, lng);
            this.reset();
        });

        // إضافة سائق جديد
        document.getElementById('add-driver-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('driver-name').value;
            const phone = document.getElementById('driver-phone').value;
            const lat = document.getElementById('driver-lat').value;
            const lng = document.getElementById('driver-lng').value;

            addNewDriver(name, phone, lat, lng);
            this.reset();
        });
    }

    // حدث تعيين السائق
    document.getElementById('assign-driver-btn')?.addEventListener('click', function() {
        const orderId = parseInt(this.dataset.orderId);
        const driverId = parseInt(document.getElementById('driver-select').value);

        if (orderId && driverId) {
            assignDriverToOrder(orderId, driverId);

            // إغلاق المودال
            const modal = bootstrap.Modal.getInstance(document.getElementById('orderModal'));
            modal.hide();
        }
    });
});
