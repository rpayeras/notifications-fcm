<?php
include('config.php');

$patientId = 1;
$doctors = [];

$stmt = $db->prepare("SELECT * FROM patients_doctors WHERE patient_id = ?");
$stmt->bind_param("i",  $patientId);
$stmt->execute();
$res = $stmt->get_result();
$rows = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

foreach($rows as $row) {
    $doctors[] = $row['doctor_id'];
}

$doctorParam = implode(',', $doctors);

$stmt = $db->prepare("SELECT * FROM users_devices WHERE user_id IN (?)");
$stmt->bind_param("i", $doctorParam);
$stmt->execute();
$res = $stmt->get_result();
$rows = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

foreach($rows as $row) {
    $data = [
        'to' => $row['token'],
        'notification' => [
            'title' => 'El paciente xxx te ha enviado un mensaje' ,
            'body' => 'El paciente xxx te ha enviado un mensaje',
            'sound' => 'default',
            'badge' => '1',
        ],
        'priority'=>'high',
        'patient_id' => $patientId
    ];

    $res = sendNotification($data);

    echo '<pre>' . var_export(json_decode($res), true) . '</pre>';
}



