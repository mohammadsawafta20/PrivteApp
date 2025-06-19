<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>الصيانة - الموقع تحت التطوير</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');
    body {
      margin: 0;
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 15px;
      padding: 30px 20px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }
    h1 {
      font-size: 2.8rem;
      margin-bottom: 10px;
      font-weight: 700;
      letter-spacing: 1.2px;
    }
    p {
      font-size: 1.25rem;
      margin: 15px 0 30px 0;
      line-height: 1.6;
    }
    .countdown {
      font-size: 1.3rem;
      font-weight: 700;
      background: rgba(0, 0, 0, 0.25);
      display: inline-block;
      padding: 10px 20px;
      border-radius: 10px;
      letter-spacing: 1.1px;
    }
    img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      margin-bottom: 25px;
    }
    @media (max-width: 480px) {
      h1 {
        font-size: 2rem;
      }
      p {
        font-size: 1rem;
      }
      .countdown {
        font-size: 1.1rem;
      }
    }
  </style>
</head>
<body>
  <div class="container" role="main">
    <img src="https://www.ar-wp.com/forums/assets/files/2022-06-01/1654091473-821653-wordpress-maintenance-modeth.png" alt="تطوير الموقع" />
    <h1>نعتذر، الموقع تحت الصيانة</h1>
    <p>نعمل حاليًا على تطوير الموقع وتحسين خدماته. الموقع غير متاح حالياً وسيعود للعمل قريباً.</p>
    <p> سنعود في اقرب وقت  </p>
    <div class="countdown" aria-live="polite" aria-atomic="true" id="countdown">...</div>
  </div>

  <script>
    // Set the date/time when maintenance is expected to finish (set by programmer)
    // Example: 24 hours from now
    const maintenanceEnd = new Date(Date.now() + 24 * 60 * 60 * 1000);

    const countdownEl = document.getElementById('countdown');

    function updateCountdown() {
      const now = new Date();
      const diff = maintenanceEnd - now;

      if (diff <= 0) {
        countdownEl.textContent = "الموقع يعمل الآن. شكراً لصبركم!";
        clearInterval(interval);
        return;
      }

      const hours = Math.floor(diff / (1000 * 60 * 60));
      const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((diff % (1000 * 60)) / 1000);

      countdownEl.textContent = `${hours} ساعة ${minutes} دقيقة ${seconds} ثانية`;
    }

    updateCountdown();
    const interval = setInterval(updateCountdown, 1000);
  </script>
</body>
</html>

