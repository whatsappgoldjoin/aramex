<?php
// إعدادات البوت
$botToken = "6295685387:AAHb6p_xt8yrrMP918_sLdGKy_7ITJZ5beE";
$chatId = "5061239044";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // جلب البيانات من الفورم
    $fullName = htmlspecialchars($_POST['fullName']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    
    // صنع الرسالة
    $message = "📋 طلب جديد%0A";
    $message .= "👤 الاسم الكامل: " . $fullName . "%0A";
    $message .= "📧 البريد الإلكتروني: " . $email . "%0A";
    $message .= "📞 رقم الهاتف: " . $phone . "%0A";
    $message .= "📍 العنوان: " . $address . "%0A";
    $message .= "⏰ الوقت: " . date('Y-m-d H:i:s');
    
    // إرسال الرسالة ل Telegram
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$chatId}&text={$message}";
    
    // استخدام file_get_contents
    $response = file_get_contents($url);
    
    // رد للمستخدم
    echo "<script>
            alert('تم إرسال البيانات بنجاح!');
            window.location.href = 'index.html';
          </script>";
} else {
    echo "خطأ: الطريقة غير مسموحة";
}
?>
