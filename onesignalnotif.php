<?php
// Masukkan App ID dan API Key dari OneSignal
define('ONESIGNAL_APP_ID', '3c88eee6-82fa-43f8-9590-abda4e40a0ad');
define('ONESIGNAL_API_KEY', 'os_v2_app_hseo5zuc7jb7rfmqvpne4qfavupjwytcyrbu7z4ja3hen2cpj34ykclkqtcdwovz5h5sgdi2cmy2zwf2htsjrnz5ezs56zglqo5dpwy');

// Fungsi untuk mengirim push notification
function sendNotification($title, $message) {
    $content = array(
        "en" => $message
    );

    $fields = array(
        'app_id' => ONESIGNAL_APP_ID,
        'included_segments' => array('All'), // Kirim ke semua pengguna
        'headings' => array("en" => $title),
        'contents' => $content
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . ONESIGNAL_API_KEY
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Tangkap data dari MIT App Inventor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = isset($_POST['title']) ? $_POST['title'] : 'Notification';
    $message = isset($_POST['message']) ? $_POST['message'] : 'Message content not set';

    // Kirim notifikasi
    $response = sendNotification($title, $message);
    echo $response;
}
?>
