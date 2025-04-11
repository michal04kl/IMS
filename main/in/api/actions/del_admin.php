<?php
include $_SERVER['DOCUMENT_ROOT'].'/main/in/dbset/dbset.php';
$id = $_POST['ID'];
$sql = "DELETE FROM `users` WHERE `ID` = '".$id."';";
$data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
$res = $data->query($sql) or die ('base error');
$data->close();
?>