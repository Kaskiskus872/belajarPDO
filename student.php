<?php
include 'koneksi.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM STUDENTS WHERE id = ?");
$stmt->execute([
    $id
]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo '<h3>' . $data['name'] .'</h3>';
echo '<b>detail : </b>  <br>';
echo $data['email'] . '<br>' . $data['telp'] . '<br> <br>';
?>