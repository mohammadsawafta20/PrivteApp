<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8" />
  <title>خريطة المتاجر والسائقين🚕</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    #map {
      height: 1500px;
      width: 80%;
      float: right;
    }
    body {
      font-family: 'Cairo', sans-serif;
      direction: rtl;
      text-align: right;
      margin: 0;
      padding: 0;
      display: flex;
    }
    .leaflet-popup-content {
      font-size: 16px;
    }
    button {
      margin-top: 5px;
      padding: 4px 10px;
      font-size: 14px;
      cursor: pointer;
    }
    /* مفتاح الخريطة */
    #legend {
      width: 20%;
      padding: 20px;
      background: #fff;
      border-left: 3px solid #aaa;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
      font-size: 16px;
      line-height: 1.6;
    }
    #legend h3 {
      margin-top: 0;
      margin-bottom: 15px;
      text-align: center;
    }
    .legend-item {
      display: flex;
      align-items: center;
      margin-bottom: 12px;
    }
    .legend-item img {
      width: 40px;
      height: 40px;
      margin-left: 10px;
    }
  </style>
</head>
<body>

<div id="map"></div>

<div id="legend">
  <h3>مفتاح الخريطة</h3>
  <div class="legend-item">
    <img src="https://cdn-icons-png.freepik.com/256/18008/18008990.png?ga=GA1.1.1293284205.1746954550&semt=ais_hybrid" alt="متجر عادي" />
    <span>متجر بدون طلب</span>
  </div>
  <div class="legend-item">
    <img src="https://cdn-icons-png.freepik.com/256/4962/4962047.png?ga=GA1.1.1293284205.1746954550&semt=ais_hybrid" alt="متجر يرسل طلب" />
    <span>متجر يرسل طلب</span>
  </div>
  <div class="legend-item">
    <img src="https://cdn-icons-png.flaticon.com/128/2401/2401174.png" alt="سائق متاح" />
    <span>سائق متاح</span>
  </div>
  <div class="legend-item">
    <img src="https://cdn-icons-png.freepik.com/256/5683/5683584.png?ga=GA1.1.1293284205.1746954550&semt=ais_hybrid" alt="سائق يقوم بالتوصيل" />
    <span>سائق في توصيل</span>
  </div>
  <br><br><br><br><br><br><br>
  <div class="legend-item"  >
    <!-- صورة متحركة لسيارة -->
    <img style="width: 200px;height:150px; " src="https://www.emojiall.com/images/240/telegram/1f695.gif" alt="سيارة متحركة" />
  </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  const map = L.map('map').setView([31.9454, 35.9284], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  const icons = {
    vendorNormal: 'https://cdn-icons-png.freepik.com/256/18008/18008990.png?ga=GA1.1.1293284205.1746954550&semt=ais_hybrid',
    vendorAlert: 'https://cdn-icons-png.freepik.com/256/4962/4962047.png?ga=GA1.1.1293284205.1746954550&semt=ais_hybrid',
    driverAvailable: 'https://cdn-icons-png.flaticon.com/128/2401/2401174.png',
    driverDelivering: 'https://cdn-icons-png.freepik.com/256/5683/5683584.png?ga=GA1.1.1293284205.1746954550&semt=ais_hybrid'
  };

  function createIcon(url) {
    return L.icon({
      iconUrl: url,
      iconSize: [80, 80],
      iconAnchor: [25, 50],
      popupAnchor: [0, -45]
    });
  }

  let vendors = [
  { id: 1, name: "متجر الزهراء", lat: 31.9454, lng: 35.9284, has_request: true, phone: "0790000001" },
  { id: 2, name: "متجر جبل عمان", lat: 31.9500, lng: 35.9300, has_request: false, phone: "0790000002" },
  { id: 3, name: "متجر القواسمي", lat: 31.9465, lng: 35.9260, has_request: true, phone: "0790000003" },
  { id: 4, name: "متجر الزهرة", lat: 31.9430, lng: 35.9250, has_request: false, phone: "0790000004" },
  { id: 5, name: "متجر الهلال", lat: 31.9475, lng: 35.9335, has_request: false, phone: "0790000005" }
];

let drivers = [
  { id: 1, name: "السائق أحمد", lat: 31.9440, lng: 35.9290, status: 'available', phone: "0780000001" },
  { id: 2, name: "السائق محمد", lat: 31.9420, lng: 35.9320, status: 'delivering', phone: "0780000002" },
  { id: 3, name: "السائق عمر", lat: 31.9495, lng: 35.9275, status: 'available', phone: "0780000003" }
];


  const vendorMarkers = new Map();
  const driverMarkers = new Map();

  function renderVendors() {
    vendors.forEach(vendor => {
      const icon = createIcon(vendor.has_request ? icons.vendorAlert : icons.vendorNormal);
      const marker = L.marker([vendor.lat, vendor.lng], { icon }).addTo(map);

      let popup = `
        <strong>اسم المتجر:</strong> ${vendor.name}<br>
        <strong>طلب جديد:</strong> ${vendor.has_request ? '🚨 نعم' : 'لا'}<br>
         <strong>رقم الجوال:</strong> ${vendor.phone}<br>
      `;

      if (vendor.has_request) {
        popup += `<button onclick="assignDriver(${vendor.id})">ربط بسائق</button>`;
      }

      marker.bindPopup(popup);
      vendorMarkers.set(vendor.id, marker);
    });
  }

  function renderDrivers() {
    drivers.forEach(driver => {
      const icon = createIcon(driver.status === 'available' ? icons.driverAvailable : icons.driverDelivering);
      const marker = L.marker([driver.lat, driver.lng], { icon }).addTo(map);

      marker.bindPopup(`
        <strong>اسم السائق:</strong> ${driver.name}<br>
        <strong>الحالة:</strong> ${driver.status === 'available' ? 'متاح' : 'جاري التوصيل'}<br>
         <strong>رقم الجوال:</strong> ${driver.phone}
      `);

      driverMarkers.set(driver.id, marker);
    });
  }

  renderVendors();
  renderDrivers();

  function updateDriverMarker(driverId) {
    const driver = drivers.find(d => d.id === driverId);
    const marker = driverMarkers.get(driverId);
    if (!driver || !marker) return;

    const newIcon = createIcon(driver.status === 'available' ? icons.driverAvailable : icons.driverDelivering);
    marker.setIcon(newIcon);

    marker.getPopup().setContent(`
      <strong>اسم السائق:</strong> ${driver.name}<br>
      <strong>الحالة:</strong> ${driver.status === 'available' ? 'متاح' : 'جاري التوصيل'}
    `);
  }

  function updateVendorMarker(vendorId) {
    const vendor = vendors.find(v => v.id === vendorId);
    const marker = vendorMarkers.get(vendorId);
    if (!vendor || !marker) return;

    const newIcon = createIcon(vendor.has_request ? icons.vendorAlert : icons.vendorNormal);
    marker.setIcon(newIcon);

    let popup = `
      <strong>اسم المتجر:</strong> ${vendor.name}<br>
      <strong>طلب جديد:</strong> ${vendor.has_request ? '🚨 نعم' : 'لا'}<br>
    `;
    if (vendor.has_request) {
      popup += `<button onclick="assignDriver(${vendor.id})">ربط بسائق</button>`;
    }
    marker.getPopup().setContent(popup);
  }

  function assignDriver(vendorId) {
    const vendor = vendors.find(v => v.id === vendorId);
    const availableDriver = drivers.find(d => d.status === 'available');

    if (!vendor || !availableDriver) {
      alert("❌ لا يوجد سائق متاح حاليًا.");
      return;
    }

    vendor.has_request = false;
    availableDriver.status = 'delivering';

    updateVendorMarker(vendor.id);
    updateDriverMarker(availableDriver.id);

    alert(`✅ تم ربط ${availableDriver.name} بالطلب من ${vendor.name}`);
  }
</script>

</body>
</html>
