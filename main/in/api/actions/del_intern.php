<?php
include $_SERVER['DOCUMENT_ROOT'].'/main/in/dbset/dbset.php';
$id = $_POST['ID'];
$sql = "SELECT * FROM `interns` WHERE `ID` = '$id';";
$data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
$res = $data->query($sql) or die ('base error');
while($line = $res->fetch_assoc()){
    $mail = $line['mail'];
}

$sql = "DELETE FROM `interns` WHERE `mail` = '".$mail."';";
$res = $data->query($sql) or die ('base error');

$sql = "DELETE FROM `users` WHERE `mail` = '".$mail."';";
$res = $data->query($sql) or die ('base error');

$data->close();
?>