<?php
include('config.php');

$patientId = 1;

$stmt = $db->prepare("SELECT * FROM patients_devices WHERE patient_id = ?");
$stmt->bind_param("i",  $patientId);
$stmt->execute();
$res = $stmt->get_result();
$rows = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

foreach($rows as $row) {
    $data = [
        'to' => $row['token'],
        'notification' => [
            'title' => 'El doctor te ha enviado un mensaje' ,
            'body' => 'El doctor te ha enviado un mensaje',
            'sound' => 'default',
            'badge' => '1',
        ],
        'priority'=>'high',
        'doctor_id' => true
    ];

    $res = sendNotification($data);

    echo '<pre>' . var_export(json_decode($res), true) . '</pre>';
}

