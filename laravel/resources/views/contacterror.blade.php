<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>  التواصل مع الإدارة للتفعيل</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Cairo&display=swap');

  body {
    margin: 0;
    font-family: 'Cairo', sans-serif;
    background: #f9f9f9;
    color: #222;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 40px 20px;
    min-height: 100vh;
  }
  .container {
    background: #fff;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-radius: 12px;
    padding: 30px;
    text-align: center;
  }
  h1 {
    margin-bottom: 18px;
    color: #0d47a1;
  }
  p.description {
    color: #f50d0d;
    margin-bottom: 30px;
    font-size: 1.2rem;
  }
  .contact-card {
    background: #e3f2fd;
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(13, 71, 161, 0.15);
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .phone-number {
    font-size: 1.3rem;
    font-weight: bold;
    margin-bottom: 14px;
    user-select: all;
  }
  .btn-group {
    display: flex;
    gap: 16px;
  }
  .btn {
    background: #0d47a1;
    border: none;
    color: white;
    padding: 10px 18px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    user-select: none;
  }
  .btn:hover {
    background: #1565c0;
  }
  .btn.call {
    background: #43a047;
  }
  .btn.call:hover {
    background: #388e3c;
  }
  .btn svg {
    width: 20px;
    height: 20px;
    fill: white;
  }
  footer {
    margin-top: 30px;
    font-size: 0.9rem;
    color: #777;
  }
</style>
</head>
<body>
  <div class="container" role="main">
    <h1>التواصل مع الإدارة</h1>
    <p class="description">   نعتذر حسابك يحتاج الى تفعيل من الادارة    </p>

    <div class="contact-card">
      <div class="phone-number" id="phone1">+966 5 1234 5678</div>
      <div class="btn-group">
        <a href="https://wa.me/966512345678" target="_blank" class="btn whatsapp" aria-label="تواصل عبر واتساب الرقم 966512345678">
          <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.52 3.48A11.865 11.865 0 0012 0C5.373 0 0 5.373 0 12a11.873 11.873 0 001.627 6.145L0 24l5.925-1.55A11.872 11.872 0 0012 24c6.627 0 12-5.373 12-12a11.848 11.848 0 00-3.48-8.52zm-8.26 16.5a8.356 8.356 0 01-4.276-1.22l-.306-.192-3.52.918.941-3.427-.2-.317a8.344 8.344 0 1117.146 1.66 8.24 8.24 0 01-8.061 2.58zM16.75 14.67c-.209-.104-1.24-.613-1.43-.682-.19-.067-.32-.1-.455.1s-.52.682-.64.823c-.117.142-.234.16-.442.054a6.302 6.302 0 01-1.85-1.15 6.996 6.996 0 01-1.3-1.613c-.137-.236 0-.36.095-.464.097-.097.215-.255.323-.382a.56.56 0 00.084-.45c-.08-.19-.455-1.1-.623-1.503s-.326-.347-.455-.352c-.117-.004-.253-.005-.39-.005a.77.77 0 00-.564.268 2.393 2.393 0 00-.73 1.75c0 1.01.525 1.99 1.194 2.543a7.913 7.913 0 003.1 2.365 3.348 3.348 0 001.505.28 2.4 2.4 0 001.47-.603 2.09 2.09 0 00.666-1.506c.003-.078.027-.197.064-.27.027-.054.098-.157.18-.237.074-.07.16-.148.236-.198z"/></svg>
          واتساب
        </a>
        <a href="tel:+966512345678" class="btn call" aria-label="مكالمة الرقم 966512345678">
          <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.62 10.79a15.466 15.466 0 006.58 6.58l2.2-2.2a1 1 0 011.11-.27 11.36 11.36 0 003.55.57 1 1 0 011 1v3.5a1 1 0 01-1 1A16 16 0 013 5a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.54 1 1 0 01-.27 1.11l-2.18 2.14z"/></svg>
          مكالمة
        </a>
      </div>
    </div>

    <div class="contact-card">
      <div class="phone-number" id="phone2">+966 5 8765 4321</div>
      <div class="btn-group">
        <a href="https://wa.me/966587654321" target="_blank" class="btn whatsapp" aria-label="تواصل عبر واتساب الرقم 966587654321">
          <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.52 3.48A11.865 11.865 0 0012 0C5.373 0 0 5.373 0 12a11.873 11.873 0 001.627 6.145L0 24l5.925-1.55A11.872 11.872 0 0012 24c6.627 0 12-5.373 12-12a11.848 11.848 0 00-3.48-8.52zm-8.26 16.5a8.356 8.356 0 01-4.276-1.22l-.306-.192-3.52.918.941-3.427-.2-.317a8.344 8.344 0 1117.146 1.66 8.24 8.24 0 01-8.061 2.58zM16.75 14.67c-.209-.104-1.24-.613-1.43-.682-.19-.067-.32-.1-.455.1s-.52.682-.64.823c-.117.142-.234.16-.442.054a6.302 6.302 0 01-1.85-1.15 6.996 6.996 0 01-1.3-1.613c-.137-.236 0-.36.095-.464.097-.097.215-.255.323-.382a.56.56 0 00.084-.45c-.08-.19-.455-1.1-.623-1.503s-.326-.347-.455-.352c-.117-.004-.253-.005-.39-.005a.77.77 0 00-.564.268 2.393 2.393 0 00-.73 1.75c0 1.01.525 1.99 1.194 2.543a7.913 7.913 0 003.1 2.365 3.348 3.348 0 001.505.28 2.4 2.4 0 001.47-.603 2.09 2.09 0 00.666-1.506c.003-.078.027-.197.064-.27.027-.054.098-.157.18-.237.074-.07.16-.148.236-.198z"/></svg>
          واتساب
        </a>
        <a href="tel:+966587654321" class="btn call" aria-label="مكالمة الرقم 966587654321">
          <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.62 10.79a15.466 15.466 0 006.58 6.58l2.2-2.2a1 1 0 011.11-.27 11.36 11.36 0 003.55.57 1 1 0 011 1v3.5a1 1 0 01-1 1A16 16 0 013 5a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.54 1 1 0 01-.27 1.11l-2.18 2.14z"/></svg>
          مكالمة
        </a>

      </div>
    </div>

    <footer>© 2025 جميع الحقوق محفوظة</footer>
  </div>
</body>
</html>
