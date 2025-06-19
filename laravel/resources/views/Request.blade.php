<!DOCTYPE html>
<html lang="ar">
<form method="POST" action="">
    @csrf
    <input type="text" name="store_name" placeholder="اسم المتجر" required>
    <textarea name="details" placeholder="تفاصيل الطلب" required></textarea>
    <input type="text" name="latitude" placeholder="خط العرض" required>
    <input type="text" name="longitude" placeholder="خط الطول" required>
    <button type="submit">إرسال الطلب</button>
</form>
