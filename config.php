<?php
const NOTIFICATIONS_URL = "https://fcm.googleapis.com/fcm/send";
const NOTIFICATIONS_KEY = '';

$dbHost = "localhost";
$username = "root";
$password = "";
$database = "notificationsfcm";

$db = new mysqli($dbHost, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

function sendNotification($data)
{
    $json = json_encode($data);
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key='. NOTIFICATIONS_KEY;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, NOTIFICATIONS_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);

    $response = curl_exec($ch);

    if ($response === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }

    curl_close($ch);

    return $response;
}

