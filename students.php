<?php
include 'koneksi.php';


$stmt = $pdo->prepare("SELECT * FROM STUDENTS");
$stmt->execute();

$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($datas as $data){
    echo '<h3>' . $data['name'] . '</h3>';
    echo '<b>detail :</b> <br> ' . $data['email'] . ' <br>' . $data['telp'] . '<br> <br>';
}
?>