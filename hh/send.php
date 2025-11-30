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
    $message = "📋 طلب جديد\n";
    $message .= "👤 الاسم الكامل: " . $fullName . "\n";
    $message .= "📧 البريد الإلكتروني: " . $email . "\n";
    $message .= "📞 رقم الهاتف: " . $phone . "\n";
    $message .= "📍 العنوان: " . $address . "\n";
    $message .= "⏰ الوقت: " . date('Y-m-d H:i:s');
    
    // إرسال الرسالة ل Telegram
    $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'Markdown'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    // رد للمستخدم
    echo "<script>
            alert('تم إرسال البيانات بنجاح!');
            window.location.href = 'index.html';
          </script>";
} else {
    echo "خطأ: الطريقة غير مسموحة";
}
?>
